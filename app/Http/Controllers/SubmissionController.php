<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $dealerId = $this->dealerId($request);

        $tasks = Task::with([
                'department',
                'area',
                'submissions' => fn ($query) => $query->where('dealer_id', $dealerId),
            ])
            ->where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('submissions.index', compact('tasks'));
    }

    public function create(Request $request, Task $task): View|RedirectResponse
    {
        $dealerId = $this->dealerId($request);
        abort_unless($task->is_active, 404);

        if ($existing = Submission::where('task_id', $task->id)->where('dealer_id', $dealerId)->first()) {
            return $existing->canResubmit()
                ? redirect()->route('submissions.edit', $existing)
                : redirect()->route('submissions.index')->with('success', 'Laporan untuk task ini sudah dikirim.');
        }

        return view('submissions.create', compact('task'));
    }

    public function store(Request $request, Task $task): RedirectResponse
    {
        $dealerId = $this->dealerId($request);
        abort_unless($task->is_active, 404);

        if (Submission::where('task_id', $task->id)->where('dealer_id', $dealerId)->exists()) {
            return redirect()->route('submissions.index')->with('success', 'Laporan untuk task ini sudah dikirim.');
        }

        $data = $this->validated($request);

        $submission = Submission::create([
            'task_id' => $task->id,
            'dealer_id' => $dealerId,
            'submitted_by' => $request->user()->id,
            'content' => $data['content'],
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('submissions', 'public') : null,
            'status' => Submission::MENUNGGU,
            'submitted_at' => now(),
        ]);

        ActivityLog::record('submit', $submission, "Submission #{$submission->id} dikirim");

        return redirect()->route('submissions.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function edit(Request $request, Submission $submission): View|RedirectResponse
    {
        $this->authorizeOwner($request, $submission);

        if (! $submission->canResubmit()) {
            return redirect()->route('submissions.index')->with('success', 'Laporan ini tidak bisa dikirim ulang.');
        }

        $submission->load('task');

        return view('submissions.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        $this->authorizeOwner($request, $submission);
        abort_unless($submission->canResubmit(), 403, 'Laporan ini tidak bisa dikirim ulang.');

        $data = $this->validated($request);
        $filePath = $submission->file_path;

        if ($request->hasFile('file')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        $submission->update([
            'content' => $data['content'],
            'file_path' => $filePath,
            'status' => Submission::MENUNGGU,
            'submitted_at' => now(),
            'resubmit_count' => $submission->resubmit_count + 1,
        ]);

        ActivityLog::record('resubmit', $submission, "Submission #{$submission->id} dikirim ulang");

        return redirect()->route('submissions.index')->with('success', 'Laporan berhasil dikirim ulang.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'content' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,xlsx,docx', 'max:5120'],
        ]);
    }

    private function dealerId(Request $request): int
    {
        $dealerId = $request->user()->dealer_id;
        abort_if(! $dealerId, 403, 'Akun dealer belum terhubung ke data dealer.');

        return $dealerId;
    }

    private function authorizeOwner(Request $request, Submission $submission): void
    {
        abort_unless($submission->dealer_id === $this->dealerId($request), 403);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Dealer;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', Submission::MENUNGGU);
        $dealerId = $request->query('dealer_id');
        $taskId = $request->query('task_id');
        $search = trim((string) $request->query('q', ''));

        $submissions = Submission::with(['task', 'dealer'])
            ->when($status !== 'SEMUA', fn ($query) => $query->where('status', $status))
            ->when($dealerId, fn ($query) => $query->where('dealer_id', $dealerId))
            ->when($taskId, fn ($query) => $query->where('task_id', $taskId))
            ->when($search !== '', fn ($query) => $query->where('content', 'like', "%{$search}%"))
            ->latest('submitted_at')
            ->paginate(10)
            ->withQueryString();

        return view('reviews.index', [
            'submissions' => $submissions,
            'status' => $status,
            'dealerId' => $dealerId,
            'taskId' => $taskId,
            'search' => $search,
            'dealers' => Dealer::orderBy('name')->get(),
            'tasks' => Task::orderBy('title')->get(),
        ]);
    }

    public function show(Submission $submission): View
    {
        $submission->load(['task.department', 'task.area', 'dealer', 'submitter', 'reviewer']);

        return view('reviews.show', compact('submission'));
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->status !== Submission::MENUNGGU) {
            return redirect()->route('reviews.index')->with('success', 'Submission ini sudah direview.');
        }

        $data = $request->validate([
            'status' => ['required', Rule::in([Submission::DISETUJUI, Submission::REVISI, Submission::DITOLAK])],
            'reviewer_note' => ['nullable', 'string', 'max:1000', 'required_if:status,' . Submission::REVISI . ',' . Submission::DITOLAK],
        ], [
            'reviewer_note.required_if' => 'Catatan wajib diisi untuk status REVISI atau DITOLAK.',
        ]);

        $submission->update([
            'status' => $data['status'],
            'reviewer_note' => $data['reviewer_note'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        ActivityLog::record(
            'review',
            $submission,
            "Submission #{$submission->id} diberi status {$data['status']}"
        );

        return redirect()->route('reviews.index')->with('success', 'Review berhasil disimpan.');
    }
}
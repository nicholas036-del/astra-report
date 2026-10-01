<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Dealer;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $submissions = $this->filteredQuery($request)
            ->with(['task', 'dealer'])
            ->paginate(10)
            ->withQueryString();

        return view('reviews.index', [
            'submissions' => $submissions,
            'status' => $request->query('status', Submission::MENUNGGU),
            'dealerId' => $request->query('dealer_id'),
            'taskId' => $request->query('task_id'),
            'search' => trim((string) $request->query('q', '')),
            'dealers' => Dealer::orderBy('name')->get(),
            'tasks' => Task::orderBy('title')->get(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $submissions = $this->filteredQuery($request)
            ->with(['task.department', 'task.area', 'dealer', 'submitter', 'reviewer'])
            ->get();

        ActivityLog::record('export', null, "Export {$submissions->count()} laporan ke CSV");

        $filename = 'laporan-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($submissions) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM supaya Excel membaca UTF-8

            fputcsv($out, [
                'ID', 'Dealer', 'Kode Dealer', 'Task', 'Department', 'Area', 'Dikirim Oleh',
                'Tanggal Kirim', 'Kirim Ulang', 'Status', 'Direview Oleh', 'Tanggal Review',
                'Catatan Review', 'Isi Laporan', 'Lampiran',
            ], ';', '"', '');

            foreach ($submissions as $submission) {
                fputcsv($out, array_map($this->safeCell(...), [
                    $submission->id,
                    $submission->dealer?->name,
                    $submission->dealer?->code,
                    $submission->task?->title,
                    $submission->task?->department?->name,
                    $submission->task?->area?->name,
                    $submission->submitter?->name,
                    $submission->submitted_at?->format('d/m/Y H:i'),
                    $submission->resubmit_count,
                    $submission->status,
                    $submission->reviewer?->name,
                    $submission->reviewed_at?->format('d/m/Y H:i'),
                    $submission->reviewer_note,
                    $submission->content,
                    $submission->file_path ? asset('storage/' . $submission->file_path) : '',
                ]), ';', '"', '');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
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

    private function filteredQuery(Request $request): Builder
    {
        $status = $request->query('status', Submission::MENUNGGU);
        $dealerId = $request->query('dealer_id');
        $taskId = $request->query('task_id');
        $search = trim((string) $request->query('q', ''));

        return Submission::query()
            ->when($status !== 'SEMUA', fn ($query) => $query->where('status', $status))
            ->when($dealerId, fn ($query) => $query->where('dealer_id', $dealerId))
            ->when($taskId, fn ($query) => $query->where('task_id', $taskId))
            ->when($search !== '', fn ($query) => $query->where('content', 'like', "%{$search}%"))
            ->latest('submitted_at');
    }

    /**
     * Cegah formula injection di Excel: sel yang diawali = + - @ diberi tanda petik.
     */
    private function safeCell(mixed $value): mixed
    {
        if (is_string($value) && $value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
            return "'" . $value;
        }

        return $value;
    }
}
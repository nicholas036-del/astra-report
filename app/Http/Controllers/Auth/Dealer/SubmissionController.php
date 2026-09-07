<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function store(Request $request, Task $task): RedirectResponse
    {
        $dealerId = $request->user()->dealer_id;

        abort_unless($dealerId, 403, 'Akun Anda belum terhubung dengan data dealer.');
        abort_if($task->isPastDue(), 403, 'Batas waktu pengumpulan tugas ini sudah lewat.');

        $existing = $task->submissions()->where('dealer_id', $dealerId)->first();

        if ($existing && ! $existing->canBeResubmitted()) {
            abort(403, 'Tugas ini sudah tidak dapat dikumpulkan ulang.');
        }

        $data = $request->validate([
            'google_drive_link' => ['required', 'url', 'max:2000'],
            'dealer_note' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($task, $dealerId, $request, $data, $existing): void {
            $submission = $task->submissions()->updateOrCreate(
                ['dealer_id' => $dealerId],
                [
                    'submitted_by' => $request->user()->id,
                    'google_drive_link' => $data['google_drive_link'],
                    'dealer_note' => $data['dealer_note'] ?? null,
                    'status' => 'REVISI',
                    'submitted_at' => now(),
                ]
            );

            $submission->logs()->create([
                'actor_id' => $request->user()->id,
                'activity' => $existing ? 'Pengumpulan Ulang' : 'Kumpul',
                'note' => $data['dealer_note'] ?? null,
            ]);
        });

        return redirect()->route('dealer.tasks.show', $task)
            ->with('status', 'Tugas berhasil dikumpulkan.');
    }
}

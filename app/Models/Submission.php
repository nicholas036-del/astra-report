<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'task_id', 'dealer_id', 'submitted_by', 'content', 'file_path', 'status',
    'reviewer_note', 'reviewed_by', 'reviewed_at', 'submitted_at', 'resubmit_count',
])]
class Submission extends Model
{
    public const MENUNGGU = 'MENUNGGU';
    public const DISETUJUI = 'DISETUJUI';
    public const REVISI = 'REVISI';
    public const DITOLAK = 'DITOLAK';

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function canResubmit(): bool
    {
        return $this->status === self::REVISI;
    }
}
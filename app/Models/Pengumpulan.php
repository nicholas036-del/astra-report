<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $fillable = ['tugas_id', 'dealer_id', 'drive_link', 'catatan', 'status'];

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PengumpulanLog::class)->orderByDesc('tanggal');
    }

    // Dealer masih bisa mengumpulkan ulang selama status REVISI dan belum lewat deadline
    public function canBeResubmitted(): bool
    {
        return $this->status === 'REVISI' && ! $this->tugas->isExpired();
    }
}

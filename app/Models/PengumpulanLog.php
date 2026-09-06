<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengumpulanLog extends Model
{
    use HasFactory;

    protected $fillable = ['pengumpulan_id', 'aktivitas', 'catatan', 'tanggal'];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function pengumpulan(): BelongsTo
    {
        return $this->belongsTo(Pengumpulan::class);
    }
}

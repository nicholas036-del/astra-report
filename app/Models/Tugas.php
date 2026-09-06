<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = ['title', 'department_id', 'area_id', 'due_at', 'created_by'];

    protected $casts = [
        'due_at' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pengumpulans(): HasMany
    {
        return $this->hasMany(Pengumpulan::class, 'tugas_id');
    }

    public function isExpired(): bool
    {
        return $this->due_at->isPast();
    }

    public function hasSubmission(): bool
    {
        return $this->pengumpulans()->exists();
    }
}

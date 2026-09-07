<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

#[Fillable(['title', 'department_id', 'area_id', 'due_at', 'created_by'])]
class Task extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'due_at' => 'date',
        ];
    }

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

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function isLocked(): bool
    {
        // Tugas tidak boleh diedit/dihapus jika sudah ada dealer yang mengumpulkan.
        return $this->submissions()->exists();
    }

    public function isPastDue(): bool
    {
        return Carbon::today()->gt($this->due_at);
    }
}


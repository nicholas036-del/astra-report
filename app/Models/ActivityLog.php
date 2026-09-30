<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

#[Fillable(['user_id', 'action', 'subject_type', 'subject_id', 'description'])]
class ActivityLog extends Model
{
    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?Model $subject = null, ?string $description = null): self
    {
        return self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
        ]);
    }
}
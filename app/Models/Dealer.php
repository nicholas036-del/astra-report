<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function pengumpulans(): HasMany
    {
        return $this->hasMany(Pengumpulan::class);
    }
}

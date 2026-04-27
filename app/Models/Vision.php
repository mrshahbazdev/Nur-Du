<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vision extends Model
{
    protected $fillable = ['user_id', 'statement'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guidingPrinciples(): HasMany
    {
        return $this->hasMany(GuidingPrinciple::class)->orderBy('sort_order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuidingPrinciple extends Model
{
    protected $fillable = ['vision_id', 'title', 'description', 'sort_order'];

    public function vision(): BelongsTo
    {
        return $this->belongsTo(Vision::class);
    }
}

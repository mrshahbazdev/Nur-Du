<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionItem extends Model
{
    protected $fillable = ['vision_check_id', 'title', 'completed'];

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
        ];
    }

    public function visionCheck(): BelongsTo
    {
        return $this->belongsTo(VisionCheck::class);
    }
}

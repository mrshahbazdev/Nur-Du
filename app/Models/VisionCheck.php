<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisionCheck extends Model
{
    protected $fillable = ['user_id', 'team_id', 'check_date', 'q1_answer', 'q2_answer', 'q3_answer', 'notes'];

    protected function casts(): array
    {
        return [
            'check_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function actionItems(): HasMany
    {
        return $this->hasMany(ActionItem::class);
    }
}

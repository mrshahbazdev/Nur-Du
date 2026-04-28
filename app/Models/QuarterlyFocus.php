<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuarterlyFocus extends Model
{
    protected $table = 'quarterly_focuses';

    protected $fillable = ['user_id', 'team_id', 'quarter', 'year', 'notes'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function strategicPriorities(): HasMany
    {
        return $this->hasMany(StrategicPriority::class);
    }

    public function getLabel(): string
    {
        return "{$this->quarter} {$this->year}";
    }
}

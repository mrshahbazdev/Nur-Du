<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StrategicPriority extends Model
{
    protected $fillable = ['quarterly_focus_id', 'title', 'owner', 'kpi', 'status', 'notes'];

    public function quarterlyFocus(): BelongsTo
    {
        return $this->belongsTo(QuarterlyFocus::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Decision extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'alignment', 'justification', 'decision_date'];

    protected function casts(): array
    {
        return [
            'decision_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

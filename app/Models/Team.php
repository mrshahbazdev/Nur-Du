<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function visions(): HasMany
    {
        return $this->hasMany(Vision::class);
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(Decision::class);
    }

    public function quarterlyFocuses(): HasMany
    {
        return $this->hasMany(QuarterlyFocus::class);
    }

    public function visionChecks(): HasMany
    {
        return $this->hasMany(VisionCheck::class);
    }
}

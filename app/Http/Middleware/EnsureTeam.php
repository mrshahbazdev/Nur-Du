<?php

namespace App\Http\Middleware;

use App\Models\Team;
use App\Models\TeamMember;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Auto-create personal team if user has no teams
        if (!$user->current_team_id) {
            $team = $user->ownedTeams()->first();

            if (!$team) {
                $team = Team::create([
                    'name' => $user->name . "'s Team",
                    'owner_id' => $user->id,
                ]);

                TeamMember::create([
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'role' => 'admin',
                ]);
            }

            $user->update(['current_team_id' => $team->id]);
            $user->refresh();
        }

        // Share current team with all views
        $currentTeam = $user->currentTeam;
        $userRole = $user->teamRole($currentTeam);

        view()->share('currentTeam', $currentTeam);
        view()->share('userRole', $userRole);

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamInvitationController extends Controller
{
    public function store(Request $request, Team $team)
    {
        $user = $request->user();
        abort_unless($user->isTeamAdmin($team), 403);

        $request->validate([
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,manager,member',
        ]);

        // Check if user is already a member
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser && $existingUser->belongsToTeam($team)) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'This user is already a team member.');
        }

        // Check for existing pending invitation
        $existingInvite = TeamInvitation::where('team_id', $team->id)
            ->where('email', $request->email)
            ->whereNull('accepted_at')
            ->first();

        if ($existingInvite) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'An invitation has already been sent to this email.');
        }

        TeamInvitation::create([
            'team_id' => $team->id,
            'invited_by' => $user->id,
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::random(64),
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Invitation sent to ' . $request->email);
    }

    public function accept(Request $request, string $token)
    {
        $invitation = TeamInvitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        $user = $request->user();

        // If user is logged in, add them directly
        if ($user) {
            if ($user->belongsToTeam($invitation->team)) {
                $invitation->update(['accepted_at' => now()]);
                return redirect()->route('dashboard')
                    ->with('info', 'You are already a member of this team.');
            }

            TeamMember::create([
                'team_id' => $invitation->team_id,
                'user_id' => $user->id,
                'role' => $invitation->role,
            ]);

            $invitation->update(['accepted_at' => now()]);
            $user->update(['current_team_id' => $invitation->team_id]);

            return redirect()->route('dashboard')
                ->with('success', 'You have joined ' . $invitation->team->name . '!');
        }

        // If not logged in, store token in session and redirect to register/login
        session(['team_invitation_token' => $token]);

        return redirect()->route('register')
            ->with('info', 'Create an account to join the team.');
    }

    public function cancel(Request $request, Team $team, TeamInvitation $invitation)
    {
        $user = $request->user();
        abort_unless($user->isTeamAdmin($team), 403);
        abort_if($invitation->team_id !== $team->id, 403);

        $invitation->delete();

        return redirect()->route('teams.show', $team)
            ->with('success', 'Invitation cancelled.');
    }
}

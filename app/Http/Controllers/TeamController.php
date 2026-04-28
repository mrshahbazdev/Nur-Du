<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $teams = $user->teams()->withCount('members')->get();
        $currentTeam = $user->currentTeam;

        return view('teams.index', compact('teams', 'currentTeam'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = $request->user();

        $team = Team::create([
            'name' => $request->name,
            'owner_id' => $user->id,
        ]);

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'admin',
        ]);

        $user->update(['current_team_id' => $team->id]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team created.');
    }

    public function show(Request $request, Team $team)
    {
        $user = $request->user();
        abort_unless($user->belongsToTeam($team), 403);

        $members = $team->teamMembers()->with('user')->get();
        $invitations = $team->invitations()->where('accepted_at', null)->get();
        $isAdmin = $user->isTeamAdmin($team);

        return view('teams.show', compact('team', 'members', 'invitations', 'isAdmin'));
    }

    public function update(Request $request, Team $team)
    {
        $user = $request->user();
        abort_unless($user->isTeamAdmin($team), 403);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update(['name' => $request->name]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team updated.');
    }

    public function switchTeam(Request $request, Team $team)
    {
        $user = $request->user();
        abort_unless($user->belongsToTeam($team), 403);

        $user->update(['current_team_id' => $team->id]);

        return redirect()->route('dashboard')
            ->with('success', 'Switched to ' . $team->name);
    }

    public function updateMemberRole(Request $request, Team $team, TeamMember $member)
    {
        $user = $request->user();
        abort_unless($user->isTeamAdmin($team), 403);
        abort_if($member->user_id === $team->owner_id, 403);

        $request->validate([
            'role' => 'required|in:admin,manager,member',
        ]);

        $member->update(['role' => $request->role]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Role updated.');
    }

    public function removeMember(Request $request, Team $team, TeamMember $member)
    {
        $user = $request->user();
        abort_unless($user->isTeamAdmin($team), 403);
        abort_if($member->user_id === $team->owner_id, 403);

        // If removed user's current team is this team, switch them
        $removedUser = $member->user;
        $member->delete();

        if ($removedUser->current_team_id === $team->id) {
            $nextTeam = $removedUser->teams()->first();
            $removedUser->update(['current_team_id' => $nextTeam?->id]);
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Member removed.');
    }

    public function destroy(Request $request, Team $team)
    {
        $user = $request->user();
        abort_unless($user->id === $team->owner_id, 403);

        // Don't allow deleting if it's the user's only team
        if ($user->teams()->count() <= 1) {
            return redirect()->route('teams.show', $team)
                ->with('error', 'Cannot delete your only team.');
        }

        $team->delete();

        // Switch to another team
        $nextTeam = $user->teams()->first();
        $user->update(['current_team_id' => $nextTeam?->id]);

        return redirect()->route('teams.index')
            ->with('success', 'Team deleted.');
    }
}

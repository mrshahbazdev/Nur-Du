<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use Illuminate\Http\Request;

class DecisionController extends Controller
{
    public function index(Request $request)
    {
        $teamId = $request->user()->current_team_id;

        $decisions = Decision::where('team_id', $teamId)
            ->orderByDesc('created_at')
            ->paginate(15);

        $stats = [
            'green' => Decision::where('team_id', $teamId)->where('alignment', 'green')->count(),
            'yellow' => Decision::where('team_id', $teamId)->where('alignment', 'yellow')->count(),
            'red' => Decision::where('team_id', $teamId)->where('alignment', 'red')->count(),
        ];

        return view('decisions.index', compact('decisions', 'stats'));
    }

    public function create()
    {
        return view('decisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'alignment' => 'required|in:green,yellow,red',
            'justification' => 'nullable|string|max:2000',
            'decision_date' => 'nullable|date',
        ]);

        $user = $request->user();

        Decision::create([
            'user_id' => $user->id,
            'team_id' => $user->current_team_id,
            ...$request->only(['title', 'description', 'alignment', 'justification', 'decision_date']),
        ]);

        return redirect()->route('decisions.index')
            ->with('success', 'Decision logged.');
    }

    public function edit(Request $request, Decision $decision)
    {
        abort_if($decision->team_id !== $request->user()->current_team_id, 403);

        return view('decisions.edit', compact('decision'));
    }

    public function update(Request $request, Decision $decision)
    {
        abort_if($decision->team_id !== $request->user()->current_team_id, 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'alignment' => 'required|in:green,yellow,red',
            'justification' => 'nullable|string|max:2000',
            'decision_date' => 'nullable|date',
        ]);

        $decision->update($request->only(['title', 'description', 'alignment', 'justification', 'decision_date']));

        return redirect()->route('decisions.index')
            ->with('success', 'Decision updated.');
    }

    public function destroy(Request $request, Decision $decision)
    {
        abort_if($decision->team_id !== $request->user()->current_team_id, 403);

        $decision->delete();

        return redirect()->route('decisions.index')
            ->with('success', 'Decision deleted.');
    }
}

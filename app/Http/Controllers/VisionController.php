<?php

namespace App\Http\Controllers;

use App\Models\Vision;
use App\Models\GuidingPrinciple;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    public function index(Request $request)
    {
        $teamId = $request->user()->current_team_id;

        $vision = Vision::where('team_id', $teamId)
            ->with('guidingPrinciples')
            ->first();

        return view('vision.index', compact('vision'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'statement' => 'required|string|max:500',
        ]);

        $user = $request->user();

        $vision = Vision::updateOrCreate(
            ['team_id' => $user->current_team_id],
            ['user_id' => $user->id, 'statement' => $request->statement],
        );

        return redirect()->route('vision.index')
            ->with('success', 'Vision statement saved.');
    }

    public function storePrinciple(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $vision = Vision::where('team_id', $request->user()->current_team_id)->firstOrFail();

        $maxOrder = $vision->guidingPrinciples()->max('sort_order') ?? 0;

        $vision->guidingPrinciples()->create([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->route('vision.index')
            ->with('success', 'Guiding principle added.');
    }

    public function updatePrinciple(Request $request, GuidingPrinciple $principle)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $vision = Vision::where('team_id', $request->user()->current_team_id)->firstOrFail();
        abort_if($principle->vision_id !== $vision->id, 403);

        $principle->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('vision.index')
            ->with('success', 'Guiding principle updated.');
    }

    public function destroyPrinciple(Request $request, GuidingPrinciple $principle)
    {
        $vision = Vision::where('team_id', $request->user()->current_team_id)->firstOrFail();
        abort_if($principle->vision_id !== $vision->id, 403);

        $principle->delete();

        return redirect()->route('vision.index')
            ->with('success', 'Guiding principle removed.');
    }
}

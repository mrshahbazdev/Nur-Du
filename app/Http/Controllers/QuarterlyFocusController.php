<?php

namespace App\Http\Controllers;

use App\Models\QuarterlyFocus;
use App\Models\StrategicPriority;
use Illuminate\Http\Request;

class QuarterlyFocusController extends Controller
{
    public function index(Request $request)
    {
        $focuses = QuarterlyFocus::where('user_id', $request->user()->id)
            ->with('strategicPriorities')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->get();

        $currentQuarter = 'Q' . ceil(now()->month / 3);
        $currentYear = now()->year;

        return view('quarterly.index', compact('focuses', 'currentQuarter', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
            'year' => 'required|integer|min:2020|max:2040',
            'notes' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

        QuarterlyFocus::updateOrCreate(
            [
                'user_id' => $user->id,
                'quarter' => $request->quarter,
                'year' => $request->year,
            ],
            ['notes' => $request->notes],
        );

        return redirect()->route('quarterly.index')
            ->with('success', 'Quarterly focus saved.');
    }

    public function show(Request $request, QuarterlyFocus $quarterlyFocus)
    {
        abort_if($quarterlyFocus->user_id !== $request->user()->id, 403);

        $quarterlyFocus->load('strategicPriorities');

        return view('quarterly.show', compact('quarterlyFocus'));
    }

    public function destroy(Request $request, QuarterlyFocus $quarterlyFocus)
    {
        abort_if($quarterlyFocus->user_id !== $request->user()->id, 403);

        $quarterlyFocus->delete();

        return redirect()->route('quarterly.index')
            ->with('success', 'Quarterly focus deleted.');
    }

    public function storePriority(Request $request, QuarterlyFocus $quarterlyFocus)
    {
        abort_if($quarterlyFocus->user_id !== $request->user()->id, 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'owner' => 'nullable|string|max:255',
            'kpi' => 'nullable|string|max:255',
        ]);

        $quarterlyFocus->strategicPriorities()->create([
            'title' => $request->title,
            'owner' => $request->owner,
            'kpi' => $request->kpi,
        ]);

        return redirect()->route('quarterly.show', $quarterlyFocus)
            ->with('success', 'Strategic priority added.');
    }

    public function updatePriority(Request $request, StrategicPriority $priority)
    {
        $focus = $priority->quarterlyFocus;
        abort_if($focus->user_id !== $request->user()->id, 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'owner' => 'nullable|string|max:255',
            'kpi' => 'nullable|string|max:255',
            'status' => 'required|in:on_track,at_risk,off_track',
            'notes' => 'nullable|string|max:2000',
        ]);

        $priority->update($request->only(['title', 'owner', 'kpi', 'status', 'notes']));

        return redirect()->route('quarterly.show', $focus)
            ->with('success', 'Priority updated.');
    }

    public function destroyPriority(Request $request, StrategicPriority $priority)
    {
        $focus = $priority->quarterlyFocus;
        abort_if($focus->user_id !== $request->user()->id, 403);

        $priority->delete();

        return redirect()->route('quarterly.show', $focus)
            ->with('success', 'Priority removed.');
    }
}

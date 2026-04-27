<?php

namespace App\Http\Controllers;

use App\Models\ActionItem;
use App\Models\VisionCheck;
use Illuminate\Http\Request;

class VisionCheckController extends Controller
{
    public function index(Request $request)
    {
        $checks = VisionCheck::where('user_id', $request->user()->id)
            ->with('actionItems')
            ->orderByDesc('check_date')
            ->paginate(12);

        return view('checks.index', compact('checks'));
    }

    public function create()
    {
        return view('checks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'check_date' => 'required|date',
            'q1_answer' => 'required|in:yes,partially,no',
            'q2_answer' => 'nullable|string|max:2000',
            'q3_answer' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:2000',
            'action_items' => 'nullable|array',
            'action_items.*' => 'string|max:255',
        ]);

        $check = VisionCheck::create([
            'user_id' => $request->user()->id,
            ...$request->only(['check_date', 'q1_answer', 'q2_answer', 'q3_answer', 'notes']),
        ]);

        if ($request->action_items) {
            foreach (array_filter($request->action_items) as $item) {
                $check->actionItems()->create(['title' => $item]);
            }
        }

        return redirect()->route('checks.index')
            ->with('success', 'Vision check recorded.');
    }

    public function show(Request $request, VisionCheck $check)
    {
        abort_if($check->user_id !== $request->user()->id, 403);

        $check->load('actionItems');

        return view('checks.show', compact('check'));
    }

    public function toggleActionItem(Request $request, ActionItem $actionItem)
    {
        $check = $actionItem->visionCheck;
        abort_if($check->user_id !== $request->user()->id, 403);

        $actionItem->update(['completed' => !$actionItem->completed]);

        return redirect()->back()->with('success', 'Action item updated.');
    }

    public function destroy(Request $request, VisionCheck $check)
    {
        abort_if($check->user_id !== $request->user()->id, 403);

        $check->delete();

        return redirect()->route('checks.index')
            ->with('success', 'Vision check deleted.');
    }
}

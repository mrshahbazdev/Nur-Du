<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use App\Models\QuarterlyFocus;
use App\Models\Vision;
use App\Models\VisionCheck;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $vision = Vision::where('user_id', $user->id)
            ->with('guidingPrinciples')
            ->first();

        $currentQuarter = 'Q' . ceil(now()->month / 3);
        $currentYear = now()->year;

        $quarterlyFocus = QuarterlyFocus::where('user_id', $user->id)
            ->where('quarter', $currentQuarter)
            ->where('year', $currentYear)
            ->with('strategicPriorities')
            ->first();

        $recentDecisions = Decision::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $decisionStats = [
            'green' => Decision::where('user_id', $user->id)->where('alignment', 'green')->count(),
            'yellow' => Decision::where('user_id', $user->id)->where('alignment', 'yellow')->count(),
            'red' => Decision::where('user_id', $user->id)->where('alignment', 'red')->count(),
        ];

        $latestCheck = VisionCheck::where('user_id', $user->id)
            ->with('actionItems')
            ->orderByDesc('check_date')
            ->first();

        return view('dashboard', compact(
            'vision',
            'quarterlyFocus',
            'currentQuarter',
            'currentYear',
            'recentDecisions',
            'decisionStats',
            'latestCheck',
        ));
    }
}

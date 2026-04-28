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
        $teamId = $user->current_team_id;

        $vision = Vision::where('team_id', $teamId)
            ->with('guidingPrinciples')
            ->first();

        $currentQuarter = 'Q' . ceil(now()->month / 3);
        $currentYear = now()->year;

        $quarterlyFocus = QuarterlyFocus::where('team_id', $teamId)
            ->where('quarter', $currentQuarter)
            ->where('year', $currentYear)
            ->with('strategicPriorities')
            ->first();

        $recentDecisions = Decision::where('team_id', $teamId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $decisionStats = [
            'green' => Decision::where('team_id', $teamId)->where('alignment', 'green')->count(),
            'yellow' => Decision::where('team_id', $teamId)->where('alignment', 'yellow')->count(),
            'red' => Decision::where('team_id', $teamId)->where('alignment', 'red')->count(),
        ];

        $latestCheck = VisionCheck::where('team_id', $teamId)
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

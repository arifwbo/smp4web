<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Facility;
use App\Models\Message;
use App\Models\Post;
use App\Models\Teacher;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'posts' => Post::count(),
            'teachers' => Teacher::count(),
            'facilities' => Facility::count(),
            'messages' => Message::count(),
        ];

        $activitySeries = $this->activitySeries();
        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'activitySeries', 'recentLogs'));
    }

    private function activitySeries(): array
    {
        $daysBack = 6;
        $start = Carbon::now()->subDays($daysBack)->startOfDay();

        $logs = ActivityLog::where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        for ($i = 0; $i <= $daysBack; $i++) {
            $date = $start->copy()->addDays($i);
            $formattedLabel = $date->translatedFormat('d M');
            $labels[] = $formattedLabel;
            $data[] = $logs[$date->toDateString()] ?? 0;
        }

        return compact('labels', 'data');
    }
}

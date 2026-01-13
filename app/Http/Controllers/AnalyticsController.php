<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Big Stats Cards
        $stats = [
            'total_sessions' => $user->studySessions()->count(),
            'total_partners' => $user->connectedPartners()->count(),
            'total_posts' => $user->blogs()->where('status', 'approved')->count(),
            'total_engagement' => $this->getTotalEngagement($user),
        ];

        // Study Activity
        $studyActivity = [
            'sessions_this_week' => $user->studySessions()
                ->whereBetween('sessionDate', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'upcoming_sessions' => $user->studySessions()
                ->where('sessionDate', '>=', Carbon::now())
                ->count(),
            'weekly_chart_data' => $this->getWeeklyChartData($user),
        ];

        // Blog Performance
        $blogPerformance = [
            'total_likes' => $user->blogs()
                ->where('status', 'approved')
                ->withCount('likes')
                ->get()
                ->sum('likes_count'),
            'total_comments' => $user->blogs()
                ->where('status', 'approved')
                ->withCount('comments')
                ->get()
                ->sum('comments_count'),
            'avg_engagement' => $this->getAverageEngagement($user),
            'top_posts' => $this->getTopPosts($user),
        ];

        return view('analytics.index', compact('stats', 'studyActivity', 'blogPerformance'));
    }

    /**
     * Get total engagement (likes + comments)
     */
    private function getTotalEngagement($user)
    {
        $blogs = $user->blogs()
            ->where('status', 'approved')
            ->withCount(['likes', 'comments'])
            ->get();
        
        return $blogs->sum('likes_count') + $blogs->sum('comments_count');
    }

    /**
     * Get average engagement per post
     */
    private function getAverageEngagement($user)
    {
        $totalPosts = $user->blogs()->where('status', 'approved')->count();
        
        if ($totalPosts === 0) {
            return 0;
        }

        $totalEngagement = $this->getTotalEngagement($user);
        
        return round($totalEngagement / $totalPosts, 1);
    }

    /**
     * Get weekly study sessions data for chart
     */
    private function getWeeklyChartData($user)
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = $user->studySessions()
                ->whereDate('sessionDate', $date)
                ->count();
            
            $data[] = [
                'date' => $date->format('D'), // Mon, Tue, Wed
                'count' => $count,
            ];
        }
        
        return $data;
    }

    /**
     * Get top 3 blog posts by engagement
     */
    private function getTopPosts($user)
    {
        return $user->blogs()
            ->where('status', 'approved')
            ->withCount(['likes', 'comments'])
            ->get()
            ->map(function($post) {
                $post->total_engagement = $post->likes_count + $post->comments_count;
                return $post;
            })
            ->sortByDesc('total_engagement')
            ->take(3);
    }
}

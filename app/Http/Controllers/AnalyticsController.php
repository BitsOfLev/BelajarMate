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
            'sessions_completed' => $user->studySessions()
                ->where('status', 'completed')
                ->count(),
            'sessions_planned' => $user->studySessions()
                ->where('status', 'planned')
                ->where('sessionDate', '>=', Carbon::now())
                ->count(),
            'sessions_cancelled' => $user->studySessions()
                ->where('status', 'cancelled')
                ->count(),
            'completion_rate' => $this->getCompletionRate($user),
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
     * Calculate completion rate (completed vs sessions that should be completed)
     */
    private function getCompletionRate($user)
    {
        $completed = $user->studySessions()->where('status', 'completed')->count();
        $cancelled = $user->studySessions()->where('status', 'cancelled')->count();
        $total = $user->studySessions()->count();
        
        // Eligible sessions = total - cancelled (sessions that COULD be completed)
        $eligible = $total - $cancelled;
        
        if ($eligible === 0) {
            return 0;
        }
        
        return round(($completed / $eligible) * 100);
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

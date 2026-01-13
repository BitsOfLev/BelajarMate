<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudySession;
use App\Models\Blog;
use App\Models\Connection;
use App\Models\Recommendation;
use Carbon\Carbon;

class SocialProfileController extends Controller
{
    public function show(User $user)
    {
        // Eager load userInfo and relationships
        $user->load([
            'userInfo.university', 
            'userInfo.course', 
            'userInfo.educationLevel', 
            'userInfo.mbti'
        ]);

        // Get user's activities from database
        $activities = [
            // Study Sessions Stats
            'total_sessions' => $user->studySessions()->count(),
            'upcoming_sessions' => $user->studySessions()
                ->where('sessionDate', '>=', now())
                ->orderBy('sessionDate', 'asc')
                ->orderBy('sessionTime', 'asc')
                ->take(3)
                ->get(),
            
            // Blog Posts
            'blog_posts' => $user->blogs()
                ->where('status', 'approved')
                ->latest()
                ->take(3)
                ->get(),
            'total_blog_posts' => $user->blogs()->where('status', 'approved')->count(),
            
            // Study Partners Count
            'total_partners' => $user->connectedPartners()->count(),
            
            // Top 3 Study Partners with Compatibility Scores
            'top_partners' => $this->getTopPartners($user),
        ];

        // Check if viewing own profile
        $isOwnProfile = auth()->check() && auth()->id() === $user->id;

        return view('study-partner.social-profile.show', compact('user', 'activities', 'isOwnProfile'));
    }

    /**
     * Get top 3 study partners by compatibility score
     */
    private function getTopPartners($user)
    {
        // Get all connected partners
        $connectedPartners = $user->connectedPartners();
        
        if ($connectedPartners->isEmpty()) {
            return collect();
        }

        // Get partner IDs
        $partnerIds = $connectedPartners->pluck('id')->toArray();

        // Fetch recommendations for these partners (scores from recommendation table)
        $recommendations = Recommendation::where('userID', $user->id)
            ->whereIn('recommendedUserID', $partnerIds)
            ->orderBy('score', 'desc')
            ->take(3)
            ->get();

        // If we have recommendations with scores
        if ($recommendations->isNotEmpty()) {
            $topPartners = [];
            
            foreach ($recommendations as $rec) {
                $partner = User::with('userInfo.mbti', 'userInfo.course')
                    ->find($rec->recommendedUserID);
                
                if ($partner) {
                    $partner->compatibility_score = round($rec->score, 0); // Round to nearest integer
                    $topPartners[] = $partner;
                }
            }
            
            return collect($topPartners);
        }

        // If no recommendations, return first 3 partners without scores
        return $connectedPartners->take(3)->map(function($partner) {
            $partner->compatibility_score = null;
            return $partner;
        });
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyPlanner;
use App\Models\StudyTask;
use App\Models\StudySession;
use App\Models\Blog;
use App\Models\Connection;
use App\Models\Note;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get active planners (planners with incomplete tasks)
        $activePlanners = StudyPlanner::where('user_id', $user->id)
            ->whereHas('tasks', function($query) {
                $query->where('taskStatus', false);
            })
            ->with(['tasks', 'category'])
            ->get();
        
        // Get INCOMPLETE tasks count (changed from completed)
        $incompleteTasksCount = StudyTask::whereHas('planner', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('taskStatus', false)
            ->count();
        
        // Get upcoming sessions (both owned and invited) 
        $upcomingSessions = StudySession::where(function($query) use ($user) {
                $query->where('userID', $user->id)
                    ->orWhereHas('invites', function($q) use ($user) {
                        $q->where('invitedUserID', $user->id)
                            ->where('invite_status', 'accepted');
                    });
            })
            ->where('status', 'planned')
            ->where(function($query) {
                // Get sessions that are today or in the future
                $query->where('sessionDate', '>', Carbon::today())
                    ->orWhere(function($q) {
                        // Or sessions today that haven't ended yet
                        $q->where('sessionDate', '=', Carbon::today())
                            ->where('sessionTime', '>=', Carbon::now()->format('H:i:s'));
                    });
            })
            ->withCount('invites')
            ->orderBy('sessionDate', 'asc')
            ->orderBy('sessionTime', 'asc')
            ->get();
        
        // Get the NEXT session (most urgent)
        $nextSession = $upcomingSessions->first();
        $nextSessionUrgency = null;
        
        if ($nextSession) {
            $sessionDate = Carbon::parse($nextSession->sessionDate);
            $sessionTime = Carbon::parse($nextSession->sessionTime);
            $sessionDateTime = $sessionDate->setTimeFrom($sessionTime);
            
            if ($sessionDateTime->isToday()) {
                $nextSessionUrgency = 'today';
            } elseif ($sessionDateTime->isTomorrow()) {
                $nextSessionUrgency = 'tomorrow';
            } elseif ($sessionDateTime->diffInDays() <= 3) {
                $nextSessionUrgency = 'soon';
            } else {
                $nextSessionUrgency = 'upcoming';
            }
        }
        
        // Get URGENT planners (due within 7 days, with incomplete tasks)
        // Using planner's due_date instead of task deadlines
        $urgentPlanners = StudyPlanner::where('user_id', $user->id)
            ->whereHas('tasks', function($query) {
                $query->where('taskStatus', false);
            })
            ->whereNotNull('due_date')
            ->where('due_date', '>=', Carbon::now()->startOfDay())
            ->with(['tasks' => function($q) {
                $q->where('taskStatus', false)
                ->orderBy('id', 'asc');
            }, 'category'])
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function($planner) {
                // Calculate progress
                $totalTasks = $planner->tasks()->count();
                $completedTasks = $planner->tasks()->where('taskStatus', true)->count();
                $planner->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                
                // Determine urgency based on planner due_date
                $planner->urgencyLevel = null;
                if ($planner->due_date) {
                    $dueDate = Carbon::parse($planner->due_date);
                    if ($dueDate->isToday()) {
                        $planner->urgencyLevel = 'today';
                    } elseif ($dueDate->isTomorrow()) {
                        $planner->urgencyLevel = 'tomorrow';
                    } elseif ($dueDate->diffInDays(now()->startOfDay()) <= 3) {
                        $planner->urgencyLevel = 'urgent';
                    } else {
                        $planner->urgencyLevel = 'normal';
                    }
                }
                
                return $planner;
            })
            ->sortBy(function($planner) {
                $order = ['today' => 1, 'tomorrow' => 2, 'urgent' => 3, 'normal' => 4];
                return $order[$planner->urgencyLevel] ?? 5;
            })
            ->values()
            ->take(3);
        
        // Get study partners count (accepted connections)
        $studyPartnersCount = Connection::where(function($query) use ($user) {
                $query->where('requesterID', $user->id)
                    ->orWhere('receiverID', $user->id);
            })
            ->where('connection_status', Connection::STATUS_ACCEPTED)
            ->count();
        
        // Get recent notes (top 3)
        $recentNotes = Note::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();
        
        // Get latest approved blog posts
        $latestBlogs = Blog::with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->where('status', 'approved')
            ->orderBy('posted_at', 'desc')
            ->take(3)
            ->get();
        
        return view('home', compact(
            'activePlanners',
            'incompleteTasksCount',
            'upcomingSessions',
            'nextSession',
            'nextSessionUrgency',
            'urgentPlanners',
            'studyPartnersCount',
            'recentNotes',
            'latestBlogs'
        ));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogReport;
use App\Models\Course;
use App\Models\University;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Urgent Actions Count
        $urgent = [
            'pending_blogs' => Blog::where('status', Blog::STATUS_PENDING)->count(),
            'pending_comments' => BlogComment::where('status', BlogComment::STATUS_PENDING)
                ->whereHas('blog') // Only comments with existing blogs
                ->count(),
            'pending_reports' => BlogReport::where('status', BlogReport::STATUS_PENDING)
                ->where(function($q) {
                    // Only reports where content still exists
                    $q->whereHas('blog')  // Blog reports with existing blog
                      ->orWhereHas('comment', function($commentQuery) {
                          $commentQuery->whereHas('blog'); // Comment reports with existing blog
                      });
                })
                ->count(),
            'pending_universities' => University::where('approval_status', 'pending')->count(),
            'pending_courses' => Course::where('approval_status', 'pending')->count(),
        ];

        // Calculate total urgent items
        $urgent['total'] = array_sum($urgent);

        // User Statistics
        $users = [
            'total' => User::count(),
            'new_today' => User::whereDate('created_at', today())->count(),
            'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // Content Statistics
        $content = [
            'total_blogs' => Blog::count(),
            'approved_blogs' => Blog::where('status', Blog::STATUS_APPROVED)->count(),
            'rejected_blogs' => Blog::where('status', Blog::STATUS_REJECTED)->count(),
            'total_comments' => BlogComment::whereHas('blog')->count(), // Only comments with existing blogs
            'approved_comments' => BlogComment::where('status', BlogComment::STATUS_APPROVED)
                ->whereHas('blog')
                ->count(),
        ];

        // Reports Statistics
        $reports = [
            'total' => BlogReport::where(function($q) {
                    $q->whereHas('blog')
                      ->orWhereHas('comment', function($commentQuery) {
                          $commentQuery->whereHas('blog');
                      });
                })->count(),
            'pending' => BlogReport::where('status', BlogReport::STATUS_PENDING)
                ->where(function($q) {
                    $q->whereHas('blog')
                      ->orWhereHas('comment', function($commentQuery) {
                          $commentQuery->whereHas('blog');
                      });
                })->count(),
            'reviewed' => BlogReport::where('status', BlogReport::STATUS_REVIEWED)
                ->where(function($q) {
                    $q->whereHas('blog')
                      ->orWhereHas('comment', function($commentQuery) {
                          $commentQuery->whereHas('blog');
                      });
                })->count(),
            'dismissed' => BlogReport::where('status', BlogReport::STATUS_DISMISSED)
                ->where(function($q) {
                    $q->whereHas('blog')
                      ->orWhereHas('comment', function($commentQuery) {
                          $commentQuery->whereHas('blog');
                      });
                })->count(),
        ];

        // Recent Activity (Last 5 items)
        $recentBlogs = Blog::with('user')->latest('created_at')->take(5)->get();
        $recentComments = BlogComment::with('user', 'blog')
            ->whereHas('blog')
            ->latest('created_at')
            ->take(5)
            ->get();
        $recentReports = BlogReport::with('user', 'blog', 'comment')
            ->where(function($q) {
                $q->whereHas('blog')
                  ->orWhereHas('comment', function($commentQuery) {
                      $commentQuery->whereHas('blog');
                  });
            })
            ->latest('created_at')
            ->take(5)
            ->get();

        // Data Management Stats
        $dataStats = [
            'universities' => University::count(),
            'courses' => Course::count(),
            'pending_data' => University::where('approval_status', 'pending')->count() + 
                             Course::where('approval_status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact(
            'urgent',
            'users',
            'content',
            'reports',
            'recentBlogs',
            'recentComments',
            'recentReports',
            'dataStats'
        ));
    }
}
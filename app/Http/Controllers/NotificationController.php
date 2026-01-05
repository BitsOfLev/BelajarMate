<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the user
     */
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id): JsonResponse
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read');
    }

    /**
     * Get unread notification count (for AJAX polling)
     */
    public function unreadCount(): JsonResponse|RedirectResponse
    {
        // Check if it's an AJAX/JSON request
        if (request()->expectsJson() || request()->ajax()) {
            $count = auth()->user()->unreadNotifications->count();
            return response()->json(['count' => $count]);
        }
        
        // If accessed directly via browser, redirect to notifications page
        return redirect()->route('notifications.index');
    }

    /**
     * Clear all read notifications for the user
     */
    public function clearRead()
    {
        $count = auth()->user()->readNotifications->count();
        auth()->user()->readNotifications()->delete();
        
        return back()->with('success', "Cleared {$count} read notifications");
    }
}
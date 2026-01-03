<?php

namespace App\Http\Controllers;

use App\Models\BlogReport;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report (for blog or comment)
     * Users can re-report if previous report was dismissed/reviewed
     */
    public function store(Request $request)
    {
        $request->validate([
            'blogID' => 'nullable|exists:blogs,blogID',
            'commentID' => 'nullable|exists:blog_comments,commentID',
            'report_reason' => 'required|string|max:1000',
        ]);

        // Must report either a blog OR a comment, not both
        if ((!$request->blogID && !$request->commentID) || ($request->blogID && $request->commentID)) {
            return back()->with('error', 'Please report either a blog or a comment, not both.');
        }

        // Check if user already has a PENDING report for this content
        // Users can report again if previous report was dismissed/reviewed
        $existingPendingReport = BlogReport::where('userID', Auth::id())
            ->where('status', BlogReport::STATUS_PENDING)
            ->where(function ($query) use ($request) {
                if ($request->blogID) {
                    $query->where('blogID', $request->blogID);
                } else {
                    $query->where('commentID', $request->commentID);
                }
            })
            ->whereNull('deleted_at')
            ->first();

        if ($existingPendingReport) {
            return back()->with('error', 'You already have a pending report for this content. Please wait for admin review.');
        }

        BlogReport::create([
            'userID' => Auth::id(),
            'blogID' => $request->blogID,
            'commentID' => $request->commentID,
            'report_reason' => $request->report_reason,
            'status' => BlogReport::STATUS_PENDING,
        ]);

        return back()->with('success', 'Report submitted successfully. Our team will review it shortly.');
    }
}

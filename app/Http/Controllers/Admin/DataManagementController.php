<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Course;
use App\Models\Mbti;
use App\Models\EducationLevel;
use Illuminate\Support\Facades\DB;

class DataManagementController extends Controller
{
    public function index(Request $request)
    {
        // Dashboard counts
        $stats = [
            'universities' => University::count(),
            'universities_pending' => University::where('approval_status', 'pending')->count(),
            'courses' => Course::count(),
            'courses_pending' => Course::where('approval_status', 'pending')->count(),
            'educationLevels' => EducationLevel::count(),
            'mbtis' => Mbti::count(),
        ];

        // Get total pending count (only Uni and Course)
        $pendingCount = $stats['universities_pending'] + $stats['courses_pending'];

        // Get filter type from request
        $filterType = $request->get('type');

        // Collect pending requests based on filter (ONLY Universities and Courses)
        $pendingRequests = collect();

        // Universities
        if (!$filterType || $filterType === 'University') {
            $universities = University::where('approval_status', 'pending')
                ->with('submittedBy')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($item) {
                    return (object) [
                        'id' => $item->uniID,
                        'entry_name' => $item->uniName,
                        'type' => 'University',
                        'submitted_by' => $item->submittedBy ? $item->submittedBy->name : 'System',
                        'created_at' => $item->created_at,
                    ];
                });
            $pendingRequests = $pendingRequests->concat($universities);
        }

        // Courses
        if (!$filterType || $filterType === 'Course') {
            $courses = Course::where('approval_status', 'pending')
                ->with('submittedBy')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($item) {
                    return (object) [
                        'id' => $item->courseID,
                        'entry_name' => $item->courseName,
                        'type' => 'Course',
                        'submitted_by' => $item->submittedBy ? $item->submittedBy->name : 'System',
                        'created_at' => $item->created_at,
                    ];
                });
            $pendingRequests = $pendingRequests->concat($courses);
        }

        // Sort by created_at descending
        $pendingRequests = $pendingRequests->sortByDesc('created_at')->values();

        // Manual pagination
        $perPage = 15;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedRequests = new \Illuminate\Pagination\LengthAwarePaginator(
            $pendingRequests->slice($offset, $perPage)->values(),
            $pendingRequests->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.data-management.index', [
            'stats' => $stats,
            'pendingRequests' => $paginatedRequests,
            'pendingCount' => $pendingCount,
        ]);
    }
}




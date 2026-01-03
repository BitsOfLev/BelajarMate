<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use App\Notifications\CourseRequestApproved;
use App\Notifications\CourseRequestRejected;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Display all courses
    public function index(Request $request)
    {
        // Calculate stats for dashboard
        $stats = [
            'total' => Course::count(),
            'approved' => Course::where('approval_status', 'approved')->count(),
            'pending' => Course::where('approval_status', 'pending')->count(),
            'rejected' => Course::where('approval_status', 'rejected')->count(),
        ];

        // Get all categories for the filter dropdown
        $categories = CourseCategory::orderBy('category_name')->get();

        // Start query
        $query = Course::with('courseCategory');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('courseName', 'like', "%{$search}%")
                  ->orWhere('courseID', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('approval_status', $request->status);
        }

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('courseCategoryID', $request->category);
        }

        // Get paginated results
        $courses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.data-management.course.index', compact('courses', 'stats', 'categories'));
    }

    // Show form to create new course
    public function create()
    {
        $categories = CourseCategory::orderBy('category_name')->get();
        return view('admin.data-management.course.create', compact('categories'));
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'courseName' => 'required|string|max:255|unique:courses,courseName',
            'courseCategoryID' => 'nullable|exists:course_categories,courseCategoryID',
        ]);

        Course::create([
            'courseName' => $request->courseName,
            'courseCategoryID' => $request->courseCategoryID,
            'approval_status' => 'approved', // Admin entries are auto-approved
            'submitted_by' => Auth::id() ?? null,
        ]);

        return redirect()->route('admin.data-management.course.index')
                         ->with('success', 'Course added successfully.');
    }

    // Edit existing course
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = CourseCategory::orderBy('category_name')->get();
        return view('admin.data-management.course.edit', compact('course', 'categories'));
    }

    // Update course
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'courseName' => 'required|string|max:255|unique:courses,courseName,' . $course->courseID . ',courseID',
            'courseCategoryID' => 'nullable|exists:course_categories,courseCategoryID',
        ]);

        $course->update([
            'courseName' => $request->courseName,
            'courseCategoryID' => $request->courseCategoryID,
        ]);

        return redirect()->route('admin.data-management.course.index')
                         ->with('success', 'Course updated successfully.');
    }

    // Delete course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.data-management.course.index')
                         ->with('success', 'Course deleted successfully.');
    }

    // Approve a pending course
    public function approve($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['approval_status' => 'approved']);

        // Send notification to submitter if exists
        if ($course->submitted_by) {
            $submitter = User::find($course->submitted_by);
            if ($submitter) {
                $submitter->notify(new CourseRequestApproved($course));
            }
        }

        return back()->with('success', 'Course approved and user notified.');
    }

    // Reject a pending course
    public function reject(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        // Get rejection reason from request (optional)
        $reason = $request->input('reason');
        
        $course->update(['approval_status' => 'rejected']);

        // Send notification to submitter if exists
        if ($course->submitted_by) {
            $submitter = User::find($course->submitted_by);
            if ($submitter) {
                $submitter->notify(new CourseRequestRejected($course, $reason));
            }
        }

        return back()->with('success', 'Course rejected and user notified.');
    }
}

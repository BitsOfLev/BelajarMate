<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use App\Models\User;
use App\Notifications\UniversityRequestApproved;
use App\Notifications\UniversityRequestRejected;
use Illuminate\Support\Facades\Auth;

class UniversityController extends Controller
{
    // Display all universities
    public function index(Request $request)
    {
        // Calculate stats for dashboard
        $stats = [
            'total' => University::count(),
            'approved' => University::where('approval_status', 'approved')->count(),
            'pending' => University::where('approval_status', 'pending')->count(),
            'rejected' => University::where('approval_status', 'rejected')->count(),
        ];

        // Start query
        $query = University::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('uniName', 'like', "%{$search}%")
                  ->orWhere('uniID', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('approval_status', $request->status);
        }

        // Get paginated results ordered by uniID ascending
        $universities = $query->orderBy('uniID', 'asc')->paginate(10);

        return view('admin.data-management.university.index', compact('universities', 'stats'));
    }

    // Show form to create new university
    public function create()
    {
        return view('admin.data-management.university.create');
    }

    // Store new university
    public function store(Request $request)
    {
        $request->validate([
            'uniName' => 'required|string|max:255|unique:universities,uniName',
        ]);

        University::create([
            'uniName' => $request->uniName,
            'approval_status' => 'approved', // Admin entries auto-approved
            'submitted_by' => Auth::id() ?? null,
        ]);

        return redirect()->route('admin.data-management.university.index')
                         ->with('success', 'University added successfully.');
    }

    // Show form to edit existing university
    public function edit($id)
    {
        $university = University::findOrFail($id);
        return view('admin.data-management.university.edit', compact('university'));
    }

    // Update university info
    public function update(Request $request, $id)
    {
        $university = University::findOrFail($id);

        $request->validate([
            'uniName' => 'required|string|max:255|unique:universities,uniName,' . $university->uniID . ',uniID',
            'approval_status' => 'required|in:pending,approved,rejected',
        ]);

        $university->update([
            'uniName' => $request->uniName,
            'approval_status' => $request->approval_status,
        ]);

        return redirect()->route('admin.data-management.university.index')
                         ->with('success', 'University updated successfully.');
    }

    // Delete university
    public function destroy($id)
    {
        $university = University::findOrFail($id);
        $university->delete();

        return redirect()->route('admin.data-management.university.index')
                         ->with('success', 'University deleted successfully.');
    }

    // Approve a pending university
    public function approve($id)
    {
        $university = University::findOrFail($id);
        $university->update(['approval_status' => 'approved']);

        // Send notification to submitter if exists
        if ($university->submitted_by) {
            $submitter = User::find($university->submitted_by);
            if ($submitter) {
                $submitter->notify(new UniversityRequestApproved($university));
            }
        }

        return back()->with('success', 'University approved and user notified.');
    }

    // Reject a pending university
    public function reject(Request $request, $id)
    {
        $university = University::findOrFail($id);
        
        // Get rejection reason from request (optional)
        $reason = $request->input('reason');
        
        $university->update(['approval_status' => 'rejected']);

        // Send notification to submitter if exists
        if ($university->submitted_by) {
            $submitter = User::find($university->submitted_by);
            if ($submitter) {
                $submitter->notify(new UniversityRequestRejected($university, $reason));
            }
        }

        return back()->with('success', 'University rejected and user notified.');
    }
}



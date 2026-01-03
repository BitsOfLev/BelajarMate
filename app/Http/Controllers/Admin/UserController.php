<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\University;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Mbti;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('userInfo');

        // Search by ID or Name only (not email, gender, etc.)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search);
            });
        }

        // Filter by role only if not "all"
        $role = $request->role ?? 'all';
        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Load user info relationship
        $user->load('userInfo');

        return view('admin.users.show', compact('user'));
    }

   // Show edit form
   public function edit(User $user)
    {
        $user->load('userInfo'); // load userInfo relationship

        if (!$user->userInfo) {
            // create empty userInfo instance so form fields won't break
            $user->userInfo = new \App\Models\UserInfo(['userID' => $user->id]);
        }

        $universities = University::all();
        $courses = Course::all();
        $educationLevels = EducationLevel::all();

        return view('admin.users.edit', compact('user', 'universities', 'courses', 'educationLevels'));
    }

    // Handle update
    public function update(Request $request, User $user)
    {
        // Validation: only validate if the field exists in the request
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'uniID' => 'nullable|exists:universities,id',
            'courseID' => 'nullable|exists:courses,id',
            'edulvlID' => 'nullable|exists:education_levels,id',
            'academicYear' => 'nullable|string|max:255',
        ]);

        // Update email if provided
        if ($request->filled('email')) {
            $user->email = $request->email;
            $user->save();
        }

        // Update userInfo if any of these fields are provided
        if ($request->filled('uniID') || $request->filled('courseID') || $request->filled('edulvlID') || $request->filled('academicYear')) {
            $userInfo = $user->userInfo ?? new UserInfo(['userID' => $user->id]);

            if ($request->filled('uniID')) $userInfo->uniID = $request->uniID;
            if ($request->filled('courseID')) $userInfo->courseID = $request->courseID;
            if ($request->filled('edulvlID')) $userInfo->edulvlID = $request->edulvlID;
            if ($request->filled('academicYear')) $userInfo->academicYear = $request->academicYear;

            $userInfo->save();
        }

        return redirect()->route('admin.users.show', $user->id)
                        ->with('success', 'User updated successfully.');
    }


    // Toggle active/restricted (optional if you add status column later)
    // public function toggleStatus(User $user)
    // {
    //     $user->status = $user->status === 'active' ? 'restricted' : 'active';
    //     $user->save();

    //     return redirect()->route('admin.users.index')->with('success', 'User status updated.');
    // }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}



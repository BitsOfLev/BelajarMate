<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SocialProfileController extends Controller
{
    public function show(User $user)
    {
        // Eager load userInfo, university, course, etc.
        $user->load(['userInfo.university', 'userInfo.course', 'userInfo.educationLevel', 'userInfo.mbti']);

        return view('study-partner.social-profile.show', compact('user'));
    }
}

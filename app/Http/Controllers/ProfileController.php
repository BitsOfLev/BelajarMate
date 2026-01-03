<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserInfo;
use App\Models\University;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Mbti;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function view(Request $request): View
    {
        return view('profile.view-profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the edit profile form
     */
    public function edit(Request $request): View
    {
        return view('profile.edit-profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = $user->email;

        // Auto-create user_info if missing
        $userInfo = $user->userInfo ?? $user->userInfo()->create();

        // Update name, email, and gender
        $user->fill($request->validated());

        // If email changed, require verification
        if ($user->isDirty('email')) {
            $newEmail = $user->email;
            
            // Mark as unverified
            $user->email_verified_at = null;
            
            // Save the new email
            $user->save();
            
            // Send verification email to NEW address
            $user->sendEmailVerificationNotification();
            
            // Security notification removed for testing
            // In production, this would be sent via queue to avoid rate limits
            
            // Handle profile image upload if present
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');

                if ($userInfo && $userInfo->profile_image && Storage::disk('public')->exists($userInfo->profile_image)) {
                    Storage::disk('public')->delete($userInfo->profile_image);
                }

                $userInfo->profile_image = $path;
                $userInfo->save();
            }
            
            return Redirect::route('profile.edit')
                ->with('status', 'email-verification-sent')
                ->with('message', 'A verification link has been sent to your new email address. Please verify it to complete the change.');
        }

        $user->save();

        // Handle profile image upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            if ($userInfo && $userInfo->profile_image && Storage::disk('public')->exists($userInfo->profile_image)) {
                Storage::disk('public')->delete($userInfo->profile_image);
            }

            $userInfo->profile_image = $path;
            $userInfo->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}





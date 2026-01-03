<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recommendation;
use App\Models\Connection;
use App\Http\Controllers\RecommendationController;
use Carbon\Carbon;

class StudyPartnerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userInfo = $user->userInfo;

        // Check if profile is incomplete
        $profileIncomplete = false;
        $requiredFields = ['uniID', 'courseID', 'edulvlID', 'preferred_time', 'preferred_mode'];
        foreach ($requiredFields as $field) {
            if (empty($userInfo?->$field)) {
                $profileIncomplete = true;
                break;
            }
        }

        // Refresh recommendations if profile is complete
        if (!$profileIncomplete) {
            $recommendationController = new RecommendationController();

            // Delete old recommendations for the user
            Recommendation::where('userID', $user->id)->delete();

            // Generate new recommendations
            $recommendationController->generateAndSaveForUser($user, $userInfo);
        }

        // Build recommendation query
        $query = Recommendation::where('userID', $user->id)
            ->orderBy('score', 'desc')
            ->with([
                'recommendedUser.userInfo.university',
                'recommendedUser.userInfo.course',
                'recommendedUser.userInfo.educationLevel',
                'recommendedUser.userInfo.mbti'
            ]);

        // Apply filters if provided
        $filter = $request->input('filter');
        if ($filter && $userInfo) {
            switch ($filter) {
                case 'same_uni':
                    $query->whereHas('recommendedUser.userInfo', fn($q) => $q->where('uniID', $userInfo->uniID));
                    break;
                case 'same_course':
                    $query->whereHas('recommendedUser.userInfo', fn($q) => $q->where('courseID', $userInfo->courseID));
                    break;
                case 'male':
                    $query->whereHas('recommendedUser', fn($q) => $q->where('gender', 'male'));
                    break;
                case 'female':
                    $query->whereHas('recommendedUser', fn($q) => $q->where('gender', 'female'));
                    break;
                case 'education_level':
                    $query->whereHas('recommendedUser.userInfo', fn($q) => $q->where('edulvlID', $userInfo->edulvlID));
                    break;
                case 'active_7_days':
                    $sevenDaysAgo = Carbon::now()->subDays(7);
                    $query->whereHas('recommendedUser', fn($q) => $q->where('last_login', '>=', $sevenDaysAgo));
                    break;
            }
        }

        // Get top 10 recommendations
        $recommendation = $query->take(10)->get();

        // Data for Connections tab
        // Incoming: Pending requests where I'm the receiver
        $incoming = Connection::where('receiverID', $user->id)
            ->where('connection_status', Connection::STATUS_PENDING)
            ->with(['requester.userInfo.university'])
            ->get();

        // Sent: Pending requests where I'm the requester
        $sent = Connection::where('requesterID', $user->id)
            ->where('connection_status', Connection::STATUS_PENDING)
            ->with(['receiver.userInfo.university'])
            ->get();

        // Accepted: All accepted connections (either direction)
        $accepted = Connection::where(function ($q) use ($user) {
                $q->where('requesterID', $user->id)
                  ->orWhere('receiverID', $user->id);
            })
            ->where('connection_status', Connection::STATUS_ACCEPTED)
            ->with(['requester.userInfo.university', 'receiver.userInfo.university'])
            ->get();

        return view('study-partner.index', compact(
            'recommendation',
            'profileIncomplete',
            'incoming',
            'sent',
            'accepted'
        ));
    }
}



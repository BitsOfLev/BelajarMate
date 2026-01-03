<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInfo;
use App\Models\MBTI;
use App\Models\University;
use App\Models\Course;
use App\Models\EducationLevel;

class UserInfoController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $userInfo = $user->userInfo;

        // Only approved entries
        $universities = University::where('approval_status', 'approved')->get();
        $courses = Course::where('approval_status', 'approved')->get();
        $levels = EducationLevel::all();
        $mbtiList = MBTI::all();

        // Check if user's current uni/course is pending
        $pendingUni = $userInfo && $userInfo->uniID 
            ? University::where('uniID', $userInfo->uniID)
                ->where('approval_status', 'pending')->first()
            : null;

        $pendingCourse = $userInfo && $userInfo->courseID 
            ? Course::where('courseID', $userInfo->courseID)
                ->where('approval_status', 'pending')->first()
            : null;

        return view('profile.edit-user-info', compact(
            'user', 'userInfo', 'universities', 'courses', 'levels', 'mbtiList', 'pendingUni', 'pendingCourse'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userInfo = $user->userInfo ?? new UserInfo(['userID' => $user->userID]);

        $failedFields = [];

        // --- Helper closure for University / Course submissions ---
        $handleSubmission = function($requestField, $otherField, $modelClass, $nameColumn, $idColumn) use ($user) {
            if ($requestField === 'other' && $otherField) {
                $existing = $modelClass::where($nameColumn, $otherField)->first();
                if ($existing) {
                    if ($existing->approval_status === 'pending') {
                        return ['id' => $existing->$idColumn, 'failed' => true, 'field' => "{$modelClass}"];
                    } else {
                        return ['id' => $existing->$idColumn, 'failed' => false];
                    }
                } else {
                    $new = $modelClass::create([
                        $nameColumn => $otherField,
                        'submitted_by' => Auth::id(),
                        'approval_status' => 'pending',
                    ]);
                    return ['id' => $new->$idColumn, 'failed' => true, 'field' => "{$modelClass}"];
                }
            }
            return ['id' => $requestField, 'failed' => false];
        };

        // --- University ---
        if ($request->has('uniID')) {
            $result = $handleSubmission($request->uniID, $request->other_uni, University::class, 'uniName', 'uniID');
            $userInfo->uniID = $result['id'];
            if ($result['failed'] ?? false) $failedFields[] = 'University';
        }

        // --- Course ---
        if ($request->has('courseID')) {
            $result = $handleSubmission($request->courseID, $request->other_course, Course::class, 'courseName', 'courseID');
            $userInfo->courseID = $result['id'];
            if ($result['failed'] ?? false) $failedFields[] = 'Course';
        }

        // --- Other fields ---
        $fields = [
            'edulvlID' => 'nullable|exists:education_levels,edulvlID',
            'academicYear' => 'nullable|string|max:10',
            'aboutMe' => 'nullable|string|max:1000',
            'preferred_time' => 'nullable|array',
            'preferred_mode' => 'nullable|array',
            'mbtiID' => 'nullable|exists:mbti_types,mbtiID',
        ];

        foreach ($fields as $field => $rule) {
            if ($request->has($field)) {
                try {
                    $value = $request->$field;
                    $validator = \Validator::make([$field => $value], [$field => $rule]);
                    if ($validator->fails()) {
                        $failedFields[] = ucfirst(str_replace('_', ' ', $field));
                    } else {
                        if (in_array($field, ['preferred_time', 'preferred_mode'])) {
                            $userInfo->$field = $value ? implode(',', $value) : null;
                        } else {
                            $userInfo->$field = $value;
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Failed to update {$field}: " . $e->getMessage());
                    $failedFields[] = ucfirst(str_replace('_', ' ', $field));
                }
            }
        }

        // --- Save user info ---
        try {
            $userInfo->save();
        } catch (\Exception $e) {
            \Log::error('Failed to save user info: ' . $e->getMessage());
            $failedFields[] = 'User Info';
        }

        // --- Prepare message ---
        if (empty($failedFields)) {
            // All success → show success message on edit page then redirect after 3 seconds
            return redirect()->route('profile.info.edit')
                ->with('status', 'All information updated successfully. Redirecting...')
                ->with('redirect', route('profile.view'));
        } else {
            $failedList = implode(', ', $failedFields);
            return redirect()->route('profile.info.edit')
                ->with('status', "All information updated successfully except: {$failedList}.");
        }
    }
}


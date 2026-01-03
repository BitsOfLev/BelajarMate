<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Recommendation;
use App\Models\Course;
use Illuminate\Support\Collection;

class RecommendationController extends Controller
{
    /**
     * Show recommendations page.
     */
    public function index()
    {
        $user = Auth::user();
        $userInfo = $user->userInfo;

        $required = ['uniID', 'courseID', 'edulvlID', 'preferred_time', 'preferred_mode'];
        $missing = [];

        if (!$userInfo) {
            $missing = $required;
        } else {
            foreach ($required as $col) {
                if (empty($userInfo->$col)) {
                    $missing[] = $col;
                }
            }
        }

        if (!empty($missing)) {
            return view('study-partner.recommended', [
                'recommendation' => collect(),
                'profileIncomplete' => true,
            ]);
        }

        // Generate recommendations
        $this->generateAndSaveForUser($user, $userInfo);
        

        // Retrieve saved recommendations ordered by score
        $recommendation = Recommendation::where('userID', $user->id)
            ->orderBy('score', 'desc')
            ->with(['recommendedUser.userInfo'])
            ->take(10)
            ->get();

        return view('study-partner.recommended', [
            'recommendation' => $recommendation,
            'profileIncomplete' => false,
        ]);

    }

    /**
     * Compute scores for potential partners and save top results.
     */
    public function generateAndSaveForUser(User $user, $userInfo)
    {
        $mbtiConfig = config('mbti', []);
        $mbtiMapping = config('mbti_mapping', []);
        $mbtiMultiplier = config('recommendation.mbti_multiplier', 50);

        $candidates = User::where('id', '!=', $user->id)
            ->whereHas('userInfo')
            ->with('userInfo')
            ->get();

        $scored = collect();

        foreach ($candidates as $candidate) {
            $cInfo = $candidate->userInfo;
            if (!$cInfo) continue;

            $score = 0;
            $factors = [];
            $academicMatch = false;

            // === TIER 1: Academic Match ===
            if (!empty($userInfo->courseID) && !empty($cInfo->courseID)) {
                if ($userInfo->courseID == $cInfo->courseID) {
                    $score += 100;
                    $factors[] = 'Same course';
                    $academicMatch = true;
                } elseif ($this->isRelatedCourse($userInfo->courseID, $cInfo->courseID)) {
                    $score += 70;
                    $factors[] = 'Related course (same category)';
                    $academicMatch = true;
                }
            }

            if (!empty($userInfo->edulvlID) && $userInfo->edulvlID == $cInfo->edulvlID) {
                $score += 25;
                $factors[] = 'Same education level';
                $academicMatch = true;
            }

            // === TIER 2: Study Preferences ===
            if ($academicMatch) 
            {
                // Preferred time
                if (!empty($userInfo->preferred_time) && !empty($cInfo->preferred_time)) {
                    $userTimes = is_array($userInfo->preferred_time) ? $userInfo->preferred_time : explode(',', $userInfo->preferred_time);
                    $candidateTimes = is_array($cInfo->preferred_time) ? $cInfo->preferred_time : explode(',', $cInfo->preferred_time);

                    if (count(array_intersect($userTimes, $candidateTimes)) > 0) {
                        $score += 15;
                        $factors[] = 'Same preferred time';
                    }
                }

                // Preferred mode
                if (!empty($userInfo->preferred_mode) && !empty($cInfo->preferred_mode)) {
                    $userModes = is_array($userInfo->preferred_mode) ? $userInfo->preferred_mode : explode(',', $userInfo->preferred_mode);
                    $candidateModes = is_array($cInfo->preferred_mode) ? $cInfo->preferred_mode : explode(',', $cInfo->preferred_mode);

                    if (count(array_intersect($userModes, $candidateModes)) > 0) {
                        $score += 10;
                        $factors[] = 'Same preferred mode';
                    }
                }
            }


            // === TIER 3: Environment Compatibility (apply if Tier 1 passed) ===
            if ($academicMatch) {
                if (!empty($userInfo->uniID) && $userInfo->uniID == $cInfo->uniID) {
                    $score += 5;
                    $factors[] = 'Same university';
                }

                if (!empty($userInfo->academicYear) && $userInfo->academicYear == $cInfo->academicYear) {
                    $score += 5;
                    $factors[] = 'Same academic year';
                }
            }

            // === TIER 3.5: Activity Recency (only if Tier 1 passed) ===
            if ($academicMatch && !empty($candidate->last_login)) {
                $daysSinceLastLogin = now()->diffInDays($candidate->last_login);

                if ($daysSinceLastLogin <= 7) {
                    $score += 10;
                    $factors[] = 'Recently active (within 7 days)';
                } elseif ($daysSinceLastLogin <= 14) {
                    $score += 5;
                    $factors[] = 'Active within 2 weeks';
                } elseif ($daysSinceLastLogin <= 30) {
                    $score += 2;
                    $factors[] = 'Active within a month';
                } else {
                    continue; // skip inactive users (>30 days)
                }
            }

            // === TIER 4: Personality Match (MBTI) ===
            if ($academicMatch && !empty($userInfo->mbtiID) && !empty($cInfo->mbtiID)) {
                $userMbtiKey = $userInfo->mbti->code ?? ($mbtiMapping[$userInfo->mbtiID] ?? null);
                $otherMbtiKey = $cInfo->mbti->code ?? ($mbtiMapping[$cInfo->mbtiID] ?? null);

                if ($userMbtiKey && $otherMbtiKey) {
                    $mbtiScore = $this->getMbtiCompatibilityScore($mbtiConfig, $userMbtiKey, $otherMbtiKey);
                    if ($mbtiScore > 0) {
                        $scaledScore = $mbtiScore * $mbtiMultiplier;
                        $score += $scaledScore;
                        $factors[] = "MBTI compatible (+$scaledScore)";
                    }
                }
            }

            // === Normalize score to percentage scale ===
            $normalizedScore = min(($score / 200) * 100, 100);

            if ($normalizedScore > 0) {
                $scored->push([
                    'candidate' => $candidate,
                    'score' => round($normalizedScore, 2),
                    'factors' => implode(', ', $factors),
                ]);
            }
        }

        $top = $scored->sortByDesc('score')->values()->take(10);
        $this->saveRecommendationsToDb($user->id, $top);
    }

    private function saveRecommendationsToDb(int $userID, Collection $topRecommendations)
    {
        Recommendation::where('userID', $userID)->delete();

        foreach ($topRecommendations as $rec) {
            Recommendation::create([
                'userID' => $userID,
                'recommendedUserID' => $rec['candidate']->id,
                'score' => $rec['score'],
                'factors' => $rec['factors'] ?? null,
            ]);
        }
    }

    private function isRelatedCourse($courseA, $courseB)
    {
        $categoryA = Course::where('courseID', $courseA)->value('courseCategoryID');
        $categoryB = Course::where('courseID', $courseB)->value('courseCategoryID');
        return $categoryA && $categoryB && $categoryA == $categoryB;
    }

    private function getMbtiCompatibilityScore(array $config, $a, $b)
    {
        return (float)($config[$a][$b] ?? 0);
    }
}








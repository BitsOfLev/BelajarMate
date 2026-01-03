<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PomodoroSession;
use App\Models\PomodoroPreset;
use Illuminate\Support\Facades\Auth;

class PomodoroSessionController extends Controller
{
    // Start a new session
    public function start(Request $request)
    {
        $request->validate([
            'preset_id' => 'required|exists:pomodoro_presets,id',
            'planner_id' => 'nullable|exists:study_planners,id',
        ]);

        $preset = PomodoroPreset::findOrFail($request->preset_id);

        $session = PomodoroSession::create([
            'user_id' => Auth::id(),
            'pomodoro_preset_id' => $preset->id,
            'planner_id' => $request->planner_id,
            'start_time' => now(),
            'cycles_completed' => 0,
            'total_focus_minutes' => 0,
            'total_break_minutes' => 0,
        ]);

        return response()->json([
            'message' => 'Pomodoro session started',
            'session_id' => $session->id
        ]);
    }

    // Complete session
    public function complete(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:pomodoro_sessions,id',
            'cycles_completed' => 'required|integer|min:0',
            'total_focus_minutes' => 'required|integer|min:0',
            'total_break_minutes' => 'required|integer|min:0',
        ]);

        $session = PomodoroSession::where('id', $request->session_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $session->update([
            'end_time' => now(),
            'cycles_completed' => $request->cycles_completed,
            'total_focus_minutes' => $request->total_focus_minutes,
            'total_break_minutes' => $request->total_break_minutes,
        ]);

        return response()->json([
            'message' => 'Pomodoro session completed',
            'session' => $session
        ]);
    }

    // Add to PomodoroSessionController
    public function history()
    {
        $sessions = PomodoroSession::where('user_id', Auth::id())
            ->with('preset')
            ->orderBy('start_time', 'desc')
            ->paginate(10);
        
        return view('pomodoro.history', compact('sessions'));
    }
}

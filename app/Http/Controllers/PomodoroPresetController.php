<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PomodoroPreset;
use App\Models\StudyPlanner;
use Illuminate\Support\Facades\Auth;

class PomodoroPresetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systemPreset = PomodoroPreset::where('preset_type', 'system')->first();
        $userPresets = PomodoroPreset::where('user_id', Auth::id())->get();
        $planners = StudyPlanner::where('user_id', Auth::id())->get();

        return view('pomodoro.index', compact('systemPreset', 'userPresets', 'planners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pomodoro.presets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'work_minutes' => 'required|integer|min:1',
            'short_break_minutes' => 'required|integer|min:1',
            'long_break_minutes' => 'required|integer|min:1',
            'work_cycles' => 'required|integer|min:1',
        ]);

        // Enforce max 3 presets per user
        if (PomodoroPreset::where('user_id', Auth::id())->count() >= 3) {
            return back()->with('error', 'Maximum 3 presets allowed.');
        }

        PomodoroPreset::create([
            'user_id' => Auth::id(),
            'preset_type' => 'custom',
            'title' => $request->title,
            'work_minutes' => $request->work_minutes,
            'short_break_minutes' => $request->short_break_minutes,
            'long_break_minutes' => $request->long_break_minutes,
            'work_cycles' => $request->work_cycles,
        ]);

        return redirect()->route('pomodoro.index')->with('success', 'Preset created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PomodoroPreset $preset)
    {
        // Check ownership and prevent editing system presets
        if ($preset->preset_type === 'system' || $preset->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pomodoro.presets.edit', compact('preset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PomodoroPreset $preset)
    {
        // Check ownership and prevent editing system presets
        if ($preset->preset_type === 'system' || $preset->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'work_minutes' => 'required|integer|min:1',
            'short_break_minutes' => 'required|integer|min:1',
            'long_break_minutes' => 'required|integer|min:1',
            'work_cycles' => 'required|integer|min:1',
        ]);

        $preset->update($request->all());

        return redirect()->route('pomodoro.index')->with('success', 'Preset updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PomodoroPreset $preset)
    {
        // Check ownership and prevent deleting system presets
        if ($preset->preset_type === 'system' || $preset->user_id !== Auth::id()) {
            abort(403);
        }

        $preset->delete();

        return redirect()->route('pomodoro.index')->with('success', 'Preset deleted!');
    }
}

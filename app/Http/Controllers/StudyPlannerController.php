<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyPlanner;
use App\Models\StudyTask;
use App\Models\StudyCategory;

class StudyPlannerController extends Controller
{
    // Display list of planners with optional filtering
    public function index(Request $request)
    {
        $query = StudyPlanner::with([
            'category',
            'tasks' => function($query) {
                $query->select('study_plan_id', 'taskStatus');
            }
        ])->where('user_id', auth()->id());

        if ($request->filled('filter') && in_array($request->filter, ['category_id', 'priority'])) {
            $query->orderBy($request->filter);
        } else {
            $query->latest();
        }

        $planners = $query->get()->map(function($planner) {
            $planner->total_tasks = $planner->tasks->count();
            $planner->completed_tasks = $planner->tasks->where('taskStatus', 1)->count();
            return $planner;
        });

        return view('study-planner.index', compact('planners'));
    }

    // Show form to create a new planner
    public function create()
    {
        $categories = StudyCategory::all();
        return view('study-planner.create', compact('categories'));
    }

    // Store new planner
    public function store(Request $request)
    {
        $validated = $request->validate([
            'studyPlanName' => 'required|string|max:255',
            'category_id' => 'nullable|exists:study_categories,id',
            'priority' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['user_id'] = auth()->id();

        StudyPlanner::create($validated);

        return redirect()->route('study-planner.index')
                         ->with('success', 'Study planner created successfully!');
    }

    // View specific planner (and its tasks)
    public function show(StudyPlanner $studyPlanner)
    {
        if ($studyPlanner->user_id !== auth()->id()) {
            abort(403);
        }

        $tasks = $studyPlanner->tasks()->get();

        return view('study-planner.show', compact('studyPlanner', 'tasks'));
    }

    // Edit planner
    public function edit(StudyPlanner $studyPlanner)
    {
        if ($studyPlanner->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = StudyCategory::all();
        return view('study-planner.edit', compact('studyPlanner', 'categories'));
    }

    // Update planner
    public function update(Request $request, StudyPlanner $studyPlanner)
    {
        if ($studyPlanner->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'studyPlanName' => 'required|string|max:255',
            'category_id' => 'nullable|exists:study_categories,id',
            'priority' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $studyPlanner->update($validated);

        return redirect()->route('study-planner.index')
                         ->with('success', 'Study planner updated successfully!');
    }

    // Delete planner
    public function destroy(StudyPlanner $studyPlanner)
    {
        if ($studyPlanner->user_id !== auth()->id()) {
            abort(403);
        }

        $studyPlanner->delete();

        return redirect()->route('study-planner.index')
                         ->with('success', 'Planner deleted successfully!');
    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyPlanner;
use App\Models\StudyTask;

class StudyTaskController extends Controller
{
    // Store new task
    public function store(Request $request, $planner)
    {
        $studyPlanner = StudyPlanner::findOrFail($planner);

        $request->validate([
            'task_name' => 'required|string|max:255',
        ]);

        $studyPlanner->tasks()->create([
            'taskName' => $request->task_name,
            'taskStatus' => false,
        ]);

        return redirect()
            ->route('study-planner.show', $studyPlanner->id)
            ->with('success', 'Task added successfully!');
    }

    // Update task
    public function update(Request $request, StudyTask $task)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
        ]);

        $task->update([
            'taskName' => $request->task_name,
        ]);

        return redirect()
            ->route('study-planner.show', $task->study_plan_id)
            ->with('success', 'Task updated successfully!');
    }

    // Delete task
    public function destroy(StudyTask $task)
    {
        $plannerId = $task->study_plan_id;
        $task->delete();
        
        return redirect()
            ->route('study-planner.show', $plannerId)
            ->with('success', 'Task deleted successfully!');
    }

    // Toggle completion (AJAX only)
    public function toggle(StudyTask $task)
    {
        $task->taskStatus = !$task->taskStatus;
        $task->save();

        $planner = $task->planner;
        $total = $planner->tasks()->count();
        $completed = $planner->tasks()->where('taskStatus', true)->count();
        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;

        return response()->json([
            'completed' => $task->taskStatus,
            'progress' => $progress,
        ]);
    }
}



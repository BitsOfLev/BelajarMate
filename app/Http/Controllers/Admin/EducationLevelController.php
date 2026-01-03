<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationLevel;

class EducationLevelController extends Controller
{
    // Display list of education levels
    public function index()
    {
        $educationLevels = EducationLevel::orderBy('edulvlID', 'asc')->paginate(10);
        return view('admin.data-management.education-level.index', compact('educationLevels'));
    }

    // Show form to create a new education level
    public function create()
    {
        return view('admin.data-management.education-level.create');
    }

    // Store new education level
    public function store(Request $request)
    {
        $request->validate([
            'edulvlType' => 'required|string|max:255|unique:education_levels,edulvlType',
        ]);

        EducationLevel::create([
            'edulvlType' => $request->edulvlType,
        ]);

        return redirect()->route('admin.data-management.education-level.index')
                         ->with('success', 'Education level added successfully.');
    }

    // Show form to edit an existing education level
    public function edit($id)
    {
        $level = EducationLevel::findOrFail($id); // fetch the education level by ID
        return view('admin.data-management.education-level.edit', compact('level'));
    }

    // Update an education level
    public function update(Request $request, $id)
    {
        $request->validate([
            'edulvlType' => 'required|string|max:255',
        ]);

        $level = EducationLevel::findOrFail($id);
        $level->update([
            'edulvlType' => $request->edulvlType,
        ]);

        return redirect()->route('admin.data-management.education-level.index')
                        ->with('success', 'Education Level updated successfully.');
    }


    // Delete an education level
    public function destroy($id)
    {
        $educationLevel = EducationLevel::findOrFail($id);
        $educationLevel->delete();

        return redirect()->route('admin.data-management.education-level.index')
                         ->with('success', 'Education level deleted successfully.');
    }
}


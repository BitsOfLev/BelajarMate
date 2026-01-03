<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;

class CourseCategoryController extends Controller
{
    // Display all course categories
    public function index(Request $request)
    {
        $query = CourseCategory::query();

        if ($request->filled('search')) { 
            $search = $request->search;
            $query->where('category_name', 'like', "%{$search}%")
                  ->orWhere('courseCategoryID', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('courseCategoryID', 'asc')->paginate(10);

        return view('admin.data-management.course.category.index', compact('categories'));
    }

    // Show form to create new category
    public function create()
    {
        return view('admin.data-management.course.category.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:course_categories,category_name',
            'description' => 'nullable|string|max:500',
        ]);

        CourseCategory::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.data-management.course.category.index')
                         ->with('success', 'Course category added successfully.');
    }

    // Edit category
    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.data-management.course.category.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = CourseCategory::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:course_categories,category_name,' . $category->courseCategoryID . ',courseCategoryID',
            'description' => 'nullable|string|max:500',
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.data-management.course.category.index')
                         ->with('success', 'Course category updated successfully.');
    }

    // Delete category
    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.data-management.course.category.index')
                         ->with('success', 'Course category deleted successfully.');
    }
}



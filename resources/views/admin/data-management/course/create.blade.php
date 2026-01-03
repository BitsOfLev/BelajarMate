@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Add New Course</h2>
        <a href="{{ route('admin.data-management.course.index') }}" 
           class="px-3 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
           Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.data-management.course.store') }}" method="POST">
            @csrf

            <!-- Course Name -->
            <div class="mb-4">
                <label for="courseName" class="block text-gray-700 font-medium mb-1">Course Name</label>
                <input type="text" name="courseName" id="courseName" value="{{ old('courseName') }}"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary"
                       placeholder="Enter course name" required>
            </div>

            <!-- Course Category -->
            <div class="mb-4">
                <label for="courseCategoryID" class="block text-gray-700 font-medium mb-1">Course Category</label>
                <select name="courseCategoryID" id="courseCategoryID" required
                        class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->courseCategoryID }}" 
                            {{ old('courseCategoryID') == $category->courseCategoryID ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submitted By (optional display, auto-set in controller) -->
            {{-- <input type="hidden" name="submitted_by" value="{{ auth()->id() }}"> --}}

            <!-- Approval Status (hidden, default to pending) -->
            <input type="hidden" name="approval_status" value="pending">

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Add Course
                </button>
                <a href="{{ route('admin.data-management.course.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                   Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection

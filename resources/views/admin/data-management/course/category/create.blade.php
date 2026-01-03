@extends('admin.layouts.admin-layout')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow border border-gray-200 p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Add New Category</h1>

    <!-- Back Button -->
    <div class="mb-5">
        <a href="{{ route('admin.data-management.course.category.index') }}" 
           class="inline-flex items-center px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    <!-- Create Form -->
    <form action="{{ route('admin.data-management.course.category.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Category Name -->
        <div>
            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
            <input type="text" id="category_name" name="category_name" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                   value="{{ old('category_name') }}" placeholder="Enter category name" required>
            @error('category_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                      placeholder="Optional description...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Save Category
            </button>
        </div>
    </form>
</div>
@endsection

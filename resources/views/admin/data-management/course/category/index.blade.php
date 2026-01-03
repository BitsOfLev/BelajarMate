@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Back button -->
    <a href="{{ route('admin.data-management.course.index') }}" 
        class="inline-flex items-center gap-3 px-4 py-2.5">
            <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-full shadow-sm hover:shadow-lg hover:bg-gray-800 transition-all cursor-pointer">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            <span class="font-bold text-gray-800 text-base">Back to Course Data Management</span>
    </a>

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Course Categories</h2>
        <a href="{{ route('admin.data-management.course.category.create') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 shadow-sm">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
               </svg>
            Add Category
        </a>
    </div>
    

    <!-- Search -->
    <form method="GET" action="{{ route('admin.data-management.course.category.index') }}" class="flex gap-2 items-center my-4">
        <input type="text" name="search" placeholder="Search Category" value="{{ request('search') }}" 
               class="px-3 py-1 border rounded-md focus:ring focus:ring-primary">
        <button type="submit" class="px-3 py-1 bg-primary text-white rounded-md hover:bg-purple-700 transition-colors">
            Search
        </button>
    </form>

    <!-- Categories Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200 w-20">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Category Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Description</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700 border-b border-gray-200 w-40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">#{{ $cat->courseCategoryID }}</td>
                    <td class="px-4 py-3 text-sm text-gray-800 border-t border-gray-200">{{ $cat->category_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">{{ $cat->description ?? '-' }}</td>
                    <td class="px-4 py-3 border-t border-gray-200 text-center">
                        <div class="flex items-center justify-center gap-2">

                            <!-- Edit Button -->
                            <a href="{{ route('admin.data-management.course.category.edit', $cat->courseCategoryID) }}" 
                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm"
                            title="Edit Category">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                        a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.data-management.course.category.destroy', $cat->courseCategoryID) }}" 
                                method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm"
                                        title="Delete Category">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                            a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                            m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500 border-t border-gray-200">No categories found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- Pagination -->
    <div class="mt-4">
        {{ $categories->withQueryString()->links() }}
    </div>
</div>
@endsection

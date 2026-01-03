@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-4">

    <!-- Back button -->
    <a href="{{ route('admin.data.index') }}" 
        class="inline-flex items-center gap-3 px-4 py-2.5">
            <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-full shadow-sm hover:shadow-lg hover:bg-gray-800 transition-all cursor-pointer">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            <span class="font-bold text-gray-800 text-base">Back to Data Management</span>
    </a>

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Course Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage and review course registrations</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.data-management.course.category.index') }}" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Categories
            </a>
            <a href="{{ route('admin.data-management.course.create') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 shadow-sm">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
               </svg>
               Add Course
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Courses</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Approved</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Rejected</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.data-management.course.index') }}" class="flex flex-wrap gap-3 items-end">
            
            <div class="flex-1 min-w-[250px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Search by name or ID..." 
                           value="{{ request('search') }}" 
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->courseCategoryID }}" {{ request('category') == $category->courseCategoryID ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" 
                        class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
                    Apply Filters
                </button>
                @if(request('search') || request('status') != 'all' || request('category') != 'all')
                <a href="{{ route('admin.data-management.course.index') }}" 
                   class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Clear
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Courses Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Table Header Info -->
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <p class="text-sm text-gray-600">
                Showing <span class="font-medium">{{ $courses->firstItem() ?? 0 }}</span> 
                to <span class="font-medium">{{ $courses->lastItem() ?? 0 }}</span> 
                of <span class="font-medium">{{ $courses->total() }}</span> results
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Approval</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($courses as $course)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            #{{ $course->courseID }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="font-medium text-gray-900">{{ $course->courseName }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($course->courseCategory)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $course->courseCategory->category_name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">No Category</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if($course->approval_status == 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Approved
                                </span>
                            @elseif($course->approval_status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">

                                <!-- Edit Button -->
                                <a href="{{ route('admin.data-management.course.edit', $course->courseID) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm"
                                   title="Edit">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.data-management.course.destroy', $course->courseID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm"
                                            title="Delete">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                         <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Approve/Reject Buttons (only for pending) -->
                                @if($course->approval_status == 'pending')
                                    <form action="{{ route('admin.data-management.course.approve', $course->courseID) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm"
                                                title="Approve"
                                                onclick="return confirm('Approve this course?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.data-management.course.reject', $course->courseID) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm"
                                                title="Reject"
                                                onclick="return confirm('Reject this course?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No courses found</p>
                            @if(request('search') || request('status') != 'all' || request('category') != 'all')
                            <p class="mt-1 text-xs text-gray-400">Try adjusting your search or filters</p>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
        {{ $courses->withQueryString()->links() }}
    </div>
    @endif

</div>
@endsection

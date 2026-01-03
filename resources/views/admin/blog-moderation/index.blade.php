@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Blog Moderation Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Review and moderate user-generated content</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- Pending Blogs Card -->
        <a href="{{ route('admin.blog-moderation.pending-blogs') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Blogs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_blogs'] ?? 0 }}</p>
                    @if($stats['pending_blogs'] > 0)
                    <p class="text-xs text-yellow-600 mt-1 font-medium">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Needs review
                        </span>
                    </p>
                    @endif
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Pending Comments Card -->
        <a href="{{ route('admin.blog-moderation.pending-comments') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Comments</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_comments'] ?? 0 }}</p>
                    @if($stats['pending_comments'] > 0)
                    <p class="text-xs text-yellow-600 mt-1 font-medium">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Needs review
                        </span>
                    </p>
                    @endif
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Pending Reports Card -->
        <a href="{{ route('admin.blog-moderation.reports', ['status' => 'pending']) }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Reports</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_reports'] ?? 0 }}</p>
                    @if($stats['pending_reports'] > 0)
                    <p class="text-xs text-red-600 mt-1 font-medium">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Requires action
                        </span>
                    </p>
                    @endif
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Total Blogs Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Blogs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_blogs'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Comments Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Comments</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_comments'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Section Header -->
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Jump to pending content that needs review</p>
                </div>
            </div>
        </div>

        <!-- Action Grid -->
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Review Blogs -->
            <a href="{{ route('admin.blog-moderation.pending-blogs') }}" 
               class="group p-5 rounded-lg border-2 border-gray-200 hover:border-yellow-400 hover:bg-yellow-50 transition-all">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-yellow-100 rounded-lg group-hover:bg-yellow-200 transition-colors">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800 group-hover:text-yellow-700">Review Pending Blogs</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['pending_blogs'] }} blog(s) waiting for approval</p>
                    </div>
                </div>
            </a>

            <!-- Review Comments -->
            <a href="{{ route('admin.blog-moderation.pending-comments') }}" 
               class="group p-5 rounded-lg border-2 border-gray-200 hover:border-orange-400 hover:bg-orange-50 transition-all">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800 group-hover:text-orange-700">Review Pending Comments</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['pending_comments'] }} comment(s) waiting for approval</p>
                    </div>
                </div>
            </a>

            <!-- Handle Reports -->
            <a href="{{ route('admin.blog-moderation.reports', ['status' => 'pending']) }}" 
               class="group p-5 rounded-lg border-2 border-gray-200 hover:border-red-400 hover:bg-red-50 transition-all">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800 group-hover:text-red-700">Handle User Reports</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['pending_reports'] }} report(s) need attention</p>
                    </div>
                </div>
            </a>
            
        </div>

    </div>

</div>
@endsection
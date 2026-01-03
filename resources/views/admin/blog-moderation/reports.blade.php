@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">User Reports</h2>
            <p class="text-sm text-gray-500 mt-1">Review and manage user-submitted reports</p>
        </div>
        <a href="{{ route('admin.blog-moderation.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Reports</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Reviewed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->where('status', 'reviewed')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Dismissed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reports->where('status', 'dismissed')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Filter Tabs -->
        <div class="px-5 py-3 bg-white border-b border-gray-200">
            <div class="flex flex-wrap gap-2">
                <!-- Status Filters -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.blog-moderation.reports') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ !request('status') && !request('type') ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        All Reports
                    </a>
                    
                    <a href="{{ route('admin.blog-moderation.reports', ['status' => 'pending']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'pending' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pending
                        </span>
                    </a>
                    
                    <a href="{{ route('admin.blog-moderation.reports', ['status' => 'reviewed']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'reviewed' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Reviewed
                        </span>
                    </a>
                    
                    <a href="{{ route('admin.blog-moderation.reports', ['status' => 'dismissed']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'dismissed' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Dismissed
                        </span>
                    </a>
                </div>

                <div class="h-8 w-px bg-gray-300"></div>

                <!-- Type Filters -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.blog-moderation.reports', ['type' => 'blog'] + request()->except('type')) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('type') == 'blog' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Blog Reports
                        </span>
                    </a>
                    
                    <a href="{{ route('admin.blog-moderation.reports', ['type' => 'comment'] + request()->except('type')) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('type') == 'comment' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Comment Reports
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporter</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported Content</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Reason</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            #{{ $report->reportID }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($report->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 truncate">{{ $report->user->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $report->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                            @if($report->blogID)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Blog
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Comment
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm max-w-xs">
                            @if($report->blog)
                                <div class="font-medium text-gray-900 truncate">{{ Str::limit($report->blog->blogTitle, 50) }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">By {{ $report->blog->user->name }}</div>
                            @elseif($report->comment)
                                <div class="text-gray-900">{{ Str::limit($report->comment->commentText, 60) }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">By {{ $report->comment->user->name }}</div>
                            @else
                                <span class="text-gray-400 italic">Content deleted</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm max-w-xs">
                            <p class="text-gray-900 truncate">{{ Str::limit($report->report_reason, 60) }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                            @if($report->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pending
                                </span>
                            @elseif($report->status === 'reviewed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Reviewed
                                </span>
                            @elseif($report->status === 'investigating')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                    </svg>
                                    investigating
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Dismissed
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ $report->created_at->format('H:i A') }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('admin.blog-moderation.show-report', $report->reportID) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 font-medium">No reports found</p>
                            <p class="mt-1 text-xs text-gray-400">
                                @if(request('status') || request('type'))
                                    Try adjusting your filters
                                @else
                                    No reports have been submitted
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            {{ $reports->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>

@endsection
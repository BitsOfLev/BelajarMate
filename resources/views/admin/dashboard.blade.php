@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-primary to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold mb-2">Welcome back, Admin!</h1>
        <p class="text-purple-100">{{ now()->format('l, F j, Y') }}</p>
    </div>

    <!-- Urgent Actions Alert -->
    @if($urgent['total'] > 0)
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-red-900">{{ $urgent['total'] }} Item(s) Require Your Attention</h3>
                <div class="mt-2 flex flex-wrap gap-3 text-sm">
                    @if($urgent['pending_blogs'] > 0)
                        <a href="{{ route('admin.blog-moderation.pending-blogs') }}" class="text-red-700 hover:text-red-900 font-medium">
                            {{ $urgent['pending_blogs'] }} Pending Blog(s) →
                        </a>
                    @endif
                    @if($urgent['pending_comments'] > 0)
                        <a href="{{ route('admin.blog-moderation.pending-comments') }}" class="text-red-700 hover:text-red-900 font-medium">
                            {{ $urgent['pending_comments'] }} Pending Comment(s) →
                        </a>
                    @endif
                    @if($urgent['pending_reports'] > 0)
                        <a href="{{ route('admin.blog-moderation.reports', ['status' => 'pending']) }}" class="text-red-700 hover:text-red-900 font-medium">
                            {{ $urgent['pending_reports'] }} Pending Report(s) →
                        </a>
                    @endif
                    @if($urgent['pending_universities'] > 0)
                        <a href="{{ route('admin.data.index', ['type' => 'University']) }}" class="text-red-700 hover:text-red-900 font-medium">
                            {{ $urgent['pending_universities'] }} Pending Universit(ies) →
                        </a>
                    @endif
                    @if($urgent['pending_courses'] > 0)
                        <a href="{{ route('admin.data.index', ['type' => 'Course']) }}" class="text-red-700 hover:text-red-900 font-medium">
                            {{ $urgent['pending_courses'] }} Pending Course(s) →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-5">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-bold text-green-900">All Clear!</h3>
                <p class="text-sm text-green-700">No pending items requiring immediate attention.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $users['total'] }}</p>
                    <p class="text-xs text-green-600 mt-1 font-medium">+{{ $users['new_this_month'] }} this month</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Blogs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Blogs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $content['total_blogs'] }}</p>
                    <p class="text-xs text-gray-600 mt-1 font-medium">{{ $content['approved_blogs'] }} approved</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Comments -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Comments</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $content['total_comments'] }}</p>
                    <p class="text-xs text-gray-600 mt-1 font-medium">{{ $content['approved_comments'] }} approved</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Reports -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Reports</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $reports['total'] }}</p>
                    <p class="text-xs text-yellow-600 mt-1 font-medium">{{ $reports['pending'] }} pending</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            
            <a href="{{ route('admin.blog-moderation.index') }}" 
               class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-primary hover:bg-purple-50 transition-all">
                <div class="p-2 bg-primary/10 rounded-lg">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Blog Moderation</p>
                    <p class="text-xs text-gray-500">Review flagged content</p>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Manage Users</p>
                    <p class="text-xs text-gray-500">View and manage users</p>
                </div>
            </a>

            <a href="{{ route('admin.data.index') }}" 
               class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Data Management</p>
                    <p class="text-xs text-gray-500">Manage universities & courses</p>
                </div>
            </a>

        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Blogs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Blogs</h3>
                <a href="{{ route('admin.blog-moderation.pending-blogs') }}" class="text-sm text-primary hover:text-primary/80">View All →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentBlogs as $blog)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold flex-shrink-0">
                            {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $blog->blogTitle }}</p>
                            <p class="text-sm text-gray-500">By {{ $blog->user->name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                @if($blog->status === 'pending')
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                @elseif($blog->status === 'approved')
                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium">Approved</span>
                                @else
                                    <span class="px-2 py-0.5 bg-red-100 text-red-800 rounded text-xs font-medium">Rejected</span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $blog->created_at ? $blog->created_at->diffForHumans() : 'Unknown date' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">No recent blogs</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Reports</h3>
                <a href="{{ route('admin.blog-moderation.reports') }}" class="text-sm text-primary hover:text-primary/80">View All →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentReports as $report)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-semibold flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ Str::limit($report->report_reason, 50) }}</p>
                            <p class="text-sm text-gray-500">Reported by {{ $report->user->name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                @if($report->status === 'pending')
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">Pending</span>
                                @elseif($report->status === 'reviewed')
                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium">Reviewed</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-800 rounded text-xs font-medium">Dismissed</span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">No recent reports</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection


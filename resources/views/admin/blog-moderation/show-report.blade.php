@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Review Report</h2>
            <p class="text-sm text-gray-500 mt-1">Review and take action on user-submitted report</p>
        </div>
        <a href="{{ route('admin.blog-moderation.reports') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Reports
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content (Left - 2 columns) -->
        <div class="lg:col-span-2 space-y-6">

            @if($report->status === 'pending' && ($report->blog || $report->comment))
                <x-review-guidelines />
            @elseif($report->status === 'investigating' && ($report->blog || $report->comment))
            <!-- Admin Investigation Guidelines -->
                <div class="bg-yellow-50 rounded-lg border border-yellow-200 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold mb-1">Admin Investigation Guidelines</p>
                            <ul class="list-disc list-inside space-y-1 text-yellow-700">
                                <li>The report is currently marked as <strong>Investigating</strong>.</li>
                                <li>Review the content carefully and gather all necessary evidence before taking any action.</li>
                                <li>
                                    Decide the appropriate action based on severity:
                                    <ul class="list-disc list-inside ml-5 text-yellow-700">
                                        <li><strong>Delete Content:</strong> If it clearly violates community guidelines.</li>
                                        <li><strong>Dismiss Report:</strong> If there is no evidence or the report is unfounded.</li>
                                        <li><strong>Revert to Pending:</strong> If the content is not severe and can be edited or improved by the author.</li>
                                    </ul>
                                </li>
                                <li>Use the <strong>Admin Notes</strong> field to document your reasoning for the action taken.</li>
                                <li>Communicate with other moderators/admins if needed for clarification.</li>
                                <li>Once the investigation is complete, update the report status and notify the reporter accordingly.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            

            <!-- Report Details Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Report Details</h3>
                        @if($report->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pending Review
                            </span>
                        @elseif($report->status === 'reviewed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Reviewed
                            </span>
                        @elseif($report->status === 'investigating')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                </svg>
                                investigating
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Dismissed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Report Info -->
                <div class="p-6 space-y-4">
                    
                    <!-- Report Type & Date -->
                    <div class="flex items-center gap-4 text-sm">
                        @if($report->blogID)
                            <span class="inline-flex items-center px-3 py-1 rounded-md bg-blue-100 text-blue-800 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Blog Report
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-md bg-orange-100 text-orange-800 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Comment Report
                            </span>
                        @endif
                        <span class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $report->created_at->format('M d, Y H:i A') }}
                        </span>
                    </div>

                    <!-- Report Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Report Reason</label>
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                            <p class="text-gray-900 leading-relaxed">{{ $report->report_reason }}</p>
                        </div>
                    </div>

                    <!-- Admin Notes (if exists) -->
                    @if($report->admin_notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Admin Notes</label>
                            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                                <p class="text-gray-900 leading-relaxed">{{ $report->admin_notes }}</p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            <!-- Reported Content Card -->
            @if($report->blog || $report->comment)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Reported Content</h3>
                </div>

                <!-- Content Preview -->
                <div class="p-6 space-y-4">
                    
                    @if($report->blog)
                        <!-- Blog Content -->
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $report->blog->blogTitle }}</h4>
                            <div class="flex items-center gap-3 text-sm text-gray-600 mb-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    {{ $report->blog->category->categoryName ?? 'Uncategorized' }}
                                </span>
                                <span>By {{ $report->blog->user->name }}</span>
                                <span>{{ $report->blog->posted_at ? $report->blog->posted_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>

                         @if($report->blog->blogImg)
                            @if($report->blog->blogImg === 'blog-default.jpg')
                                <img src="{{ asset('img/blog-default.jpg') }}" alt="{{ $report->blog->blogTitle }}" class="blog-hero-image">
                            @else
                                <img src="{{ asset('storage/'.$report->blog->blogImg) }}" alt="{{ $report->blog->blogTitle }}" class="blog-hero-image">
                            @endif
                        @endif

                        <div>
                            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg border border-gray-200">
                                {!! nl2br(e($report->blog->blogContent)) !!}
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <!-- <a href="{{ route('blog.show', $report->blog->blogID) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                View Full Blog
                            </a> -->

                            @if($report->blog->status === 'pending')
                                <a href="{{ route('admin.blog-moderation.show-blog', $report->blog->blogID) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Blog Also Pending Review
                                </a>
                            @endif
                        </div>

                    @elseif($report->comment)
                        <!-- Comment Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Comment Text</label>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <p class="text-gray-900 leading-relaxed">{{ $report->comment->commentText }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Comment Author</label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold">
                                    {{ strtoupper(substr($report->comment->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $report->comment->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $report->comment->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Parent Blog</label>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h5 class="font-semibold text-gray-900">{{ $report->comment->blog->blogTitle }}</h5>
                                <p class="text-sm text-gray-600 mt-1">By {{ $report->comment->blog->user->name }}</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('blog.show', $report->comment->blog->blogID) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                View in Context
                            </a>

                            @if($report->comment->status === 'pending')
                                <a href="{{ route('admin.blog-moderation.show-comment', $report->comment->commentID) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Comment Also Pending Review
                                </a>
                            @endif
                        </div>
                    @endif

                </div>

            </div>
            @else
                <!-- Content Deleted -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Content No Longer Available</h4>
                    <p class="text-sm text-gray-500">The reported content has been deleted and is no longer accessible.</p>
                </div>
            @endif

        </div>

        <!-- Sidebar (Right - 1 column) -->
        <div class="space-y-6">
            
            <!-- Reporter Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Reporter Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-2xl flex-shrink-0">
                            {{ strtoupper(substr($report->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 truncate">{{ $report->user->name }}</h4>
                            <p class="text-sm text-gray-500 truncate">{{ $report->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">User ID:</span>
                            <span class="font-medium text-gray-900">#{{ $report->user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Reports Filed:</span>
                            <span class="font-medium text-gray-900">{{ $report->user->reports()->count() }}</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.index') }}?search={{ $report->user->email }}" 
                       class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View User Profile
                    </a>
                </div>
            </div>

            <!-- Actions Card -->
            @if($report->status === 'pending' && ($report->blog || $report->comment))
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    
                    <!-- Mark as Investigating Button -->
                    <button type="button"
                            onclick="openInvestigateModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Mark as Investigating
                    </button>

                    <!-- Revert to Pending for Edit Button -->
                    <button type="button"
                            onclick="openRevertModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Send Back for Revision
                    </button>

                    <!-- Delete Content Button -->
                    <button type="button"
                            onclick="openDeleteContentModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Content
                    </button>

                    <!-- Dismiss Report Button -->
                    <button type="button"
                            onclick="openDismissModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Dismiss Report
                    </button>

                </div>
            </div>
            @elseif($report->status === 'investigating' && ($report->blog || $report->comment))
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Actions</h3>
                </div>
                <div class="p-6 space-y-3">

                    <!-- Revert to Pending for Edit Button -->
                    <button type="button"
                            onclick="openRevertModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Send Back for Revision
                    </button>

                    <!-- Delete Content Button -->
                    <button type="button"
                            onclick="openDeleteContentModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Content
                    </button>

                    <!-- Dismiss Report Button -->
                    <button type="button"
                            onclick="openDismissModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Dismiss Report
                    </button>

                </div>
            </div>
            @elseif($report->status !== 'pending' && $report->status !== 'investigating')
                <!-- Report Already Handled -->
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Report Already Handled</p>
                            <p class="text-blue-700">This report has been {{ $report->status }}. No further action is required.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Delete Content Modal -->
<div id="deleteContentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Delete Reported Content</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.action-report', $report->reportID) }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="delete_content">
            <div class="px-6 py-4 space-y-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <strong>Warning:</strong> This will permanently delete the reported {{ $report->blogID ? 'blog' : 'comment' }}. This action cannot be undone.
                    </p>
                </div>
                
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Deletion <span class="text-red-500">*</span>
                    </label>
                    <textarea id="admin_notes" 
                              name="admin_notes" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Explain why this content is being deleted. The content owner will be notified."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeDeleteContentModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Delete Content
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Dismiss Report Modal -->
<div id="dismissModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Dismiss Report</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.dismiss-report', $report->reportID) }}" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <p class="text-sm text-gray-600">
                    Dismissing this report means the content does not violate community guidelines. The reported content will remain published.
                </p>
                
                <div>
                    <label for="dismiss_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Dismissal <span class="text-red-500">*</span>
                    </label>
                    <textarea id="dismiss_notes" 
                              name="admin_notes" 
                              rows="3" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Explain why this report is being dismissed. The reporter will see this message."></textarea>
                    <p class="text-xs text-gray-500 mt-1">The reporter will be notified with this explanation.</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeDismissModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    Dismiss Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Mark as Investigating Modal -->
<div id="investigateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Mark Report as Investigating</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.investigate-report', $report->reportID) }}" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        The reporter will be notified that their report is under investigation. The content will remain as-is while you review.
                    </p>
                </div>
                
                <div>
                    <label for="investigate_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Admin Notes (Optional)
                    </label>
                    <textarea id="investigate_notes" 
                              name="admin_notes" 
                              rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Add notes about your investigation..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeInvestigateModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Mark as Investigating
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Revert to Pending Modal -->
<div id="revertModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Send Content Back for Revision</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.revert-report', $report->reportID) }}" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        The {{ $report->blogID ? 'blog' : 'comment' }} will be reverted to "Pending" status. The author can edit and resubmit it for approval.
                    </p>
                </div>
                
                <div>
                    <label for="revert_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Feedback for Author <span class="text-red-500">*</span>
                    </label>
                    <textarea id="revert_notes" 
                              name="admin_notes" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Explain what needs to be changed. The author will see this message."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Be specific about what needs to be fixed so the author can make appropriate changes.</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeRevertModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                    Send for Revision
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Investigate Modal
    function openInvestigateModal() {
        document.getElementById('investigateModal').classList.remove('hidden');
    }

    function closeInvestigateModal() {
        document.getElementById('investigateModal').classList.add('hidden');
    }

    // Revert Modal
    function openRevertModal() {
        document.getElementById('revertModal').classList.remove('hidden');
    }

    function closeRevertModal() {
        document.getElementById('revertModal').classList.add('hidden');
    }

    // Delete Content Modal (keep existing)
    function openDeleteContentModal() {
        document.getElementById('deleteContentModal').classList.remove('hidden');
    }

    function closeDeleteContentModal() {
        document.getElementById('deleteContentModal').classList.add('hidden');
    }

    // Dismiss Modal (keep existing)
    function openDismissModal() {
        document.getElementById('dismissModal').classList.remove('hidden');
    }

    function closeDismissModal() {
        document.getElementById('dismissModal').classList.add('hidden');
    }

    // Close modals on outside click
    document.getElementById('investigateModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeInvestigateModal();
    });

    document.getElementById('revertModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRevertModal();
    });

    document.getElementById('deleteContentModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteContentModal();
    });

    document.getElementById('dismissModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDismissModal();
    });
</script>

@endsection
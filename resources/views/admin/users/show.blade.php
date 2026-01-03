@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">
    
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">User Details</h2>
            <p class="text-sm text-gray-500 mt-1">Viewing for moderation purposes</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Info (Left - 2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $user->name }}</h4>
                            <p class="text-sm text-gray-500">User ID: #{{ $user->id }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Role:</span>
                            <span class="font-medium text-gray-900 ml-2">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-medium">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">User</span>
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500">Join Date:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Account Age:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Academic Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">University:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->userInfo?->university->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Course:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->userInfo?->course->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Education Level:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->userInfo?->educationLevel->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Academic Year:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $user->userInfo?->academicYear ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info (Shown for Moderation) -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-200 bg-blue-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-blue-900">Contact Information (Moderation Access)</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-sm">
                        <span class="text-blue-700">Email:</span>
                        <span class="font-medium text-blue-900 ml-2">{{ $user->email }}</span>
                    </div>
                    <p class="text-xs text-blue-600 mt-2">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Contact information is only shown to admins for moderation and support purposes.
                    </p>
                </div>
            </div>

        </div>

        <!-- Sidebar (Right - 1 column) -->
        <div class="space-y-6">
            
            <!-- Activity Stats Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Activity Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Blogs:</span>
                        <span class="text-lg font-bold text-gray-900">{{ $user->blogs()->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Comments:</span>
                        <span class="text-lg font-bold text-gray-900">{{ $user->blogComments()->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending Blogs:</span>
                        <span class="text-lg font-bold text-yellow-600">{{ $user->blogs()->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending Comments:</span>
                        <span class="text-lg font-bold text-yellow-600">{{ $user->blogComments()->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Reports Filed:</span>
                        <span class="text-lg font-bold text-gray-900">{{ $user->reports()->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Moderation Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Moderation Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    
                    <!-- View User's Blogs -->
                    <a href="{{ route('admin.blog-moderation.pending-blogs') }}?author={{ $user->id }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        View User's Blogs
                    </a>

                    <!-- View Reports About User -->
                    <a href="{{ route('admin.blog-moderation.reports') }}?reported_user={{ $user->id }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        View Reports
                    </a>

                    <!-- Delete User -->
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete User
                        </button>
                    </form>

                </div>
            </div>

            <!-- Privacy Notice -->
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold mb-1">Privacy Notice</p>
                        <p class="text-xs">Sensitive user information (email, personal details) is only accessible to admins for moderation and support purposes. This access is logged and monitored.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection


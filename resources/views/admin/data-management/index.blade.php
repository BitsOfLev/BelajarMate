@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Management Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Overview and manage all data entries</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Universities Card -->
        <a href="{{ route('admin.data-management.university.index') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Universities</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['universities'] ?? 0 }}</p>
                    @if(isset($stats['universities_pending']) && $stats['universities_pending'] > 0)
                    <p class="text-xs text-yellow-600 mt-1 font-medium">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $stats['universities_pending'] }} pending
                        </span>
                    </p>
                    @endif
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Courses Card -->
        <a href="{{ route('admin.data-management.course.index') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Courses</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['courses'] ?? 0 }}</p>
                    @if(isset($stats['courses_pending']) && $stats['courses_pending'] > 0)
                    <p class="text-xs text-yellow-600 mt-1 font-medium">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $stats['courses_pending'] }} pending
                        </span>
                    </p>
                    @endif
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Education Levels Card (No pending approval) -->
        <a href="{{ route('admin.data-management.education-level.index') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Education Levels</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['educationLevels'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- MBTI Types Card (No pending approval) -->
        <a href="{{ route('admin.data-management.mbti.index') }}" 
           class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">MBTI Types</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['mbtis'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </a>
        
    </div>

    <!-- Pending Approval Requests Section (ONLY for Universities and Courses) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Section Header -->
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Pending Approval Requests</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Review and approve Universities & Courses submissions</p>
                </div>
                @if(isset($pendingCount) && $pendingCount > 0)
                <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                    {{ $pendingCount }} Pending
                </span>
                @endif
            </div>
        </div>

        <!-- Filter Tabs (Only University and Course) -->
        <div class="px-5 py-3 bg-white border-b border-gray-200">
            <div class="flex gap-2 overflow-x-auto">
                <a href="{{ route('admin.data.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ !request('type') ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        All
                        @if(isset($pendingCount) && $pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ !request('type') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $pendingCount }}
                        </span>
                        @endif
                    </span>
                </a>
                
                <a href="{{ route('admin.data.index', ['type' => 'University']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('type') == 'University' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        Universities
                        @if(isset($stats['universities_pending']) && $stats['universities_pending'] > 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ request('type') == 'University' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $stats['universities_pending'] }}
                        </span>
                        @endif
                    </span>
                </a>
                
                <a href="{{ route('admin.data.index', ['type' => 'Course']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('type') == 'Course' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        Courses
                        @if(isset($stats['courses_pending']) && $stats['courses_pending'] > 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ request('type') == 'Course' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $stats['courses_pending'] }}
                        </span>
                        @endif
                    </span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entry Name</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted By</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingRequests as $request)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-500">
                            #{{ $request->id }}
                        </td>
                        <td class="px-5 py-3 text-sm">
                            <div class="font-medium text-gray-900">{{ $request->entry_name }}</div>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-sm">
                            @if($request->type === 'University')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    University
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Course
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">
                            {{ $request->submitted_by ?? 'System' }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($request->type === 'University')
                                    <!-- Approve University -->
                                    <form action="{{ route('admin.data-management.university.approve', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium"
                                                onclick="return confirm('Approve this university?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <!-- Reject University -->
                                    <form action="{{ route('admin.data-management.university.reject', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium"
                                                onclick="return confirm('Reject this university?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                        </button>
                                    </form>
                                @elseif($request->type === 'Course')
                                    <!-- Approve Course -->
                                    <form action="{{ route('admin.data-management.course.approve', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium"
                                                onclick="return confirm('Approve this course?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <!-- Reject Course -->
                                    <form action="{{ route('admin.data-management.course.reject', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium"
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
                        <td colspan="6" class="px-5 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 font-medium">No pending requests</p>
                            <p class="mt-1 text-xs text-gray-400">All submissions have been reviewed</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($pendingRequests, 'hasPages') && $pendingRequests->hasPages())
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            {{ $pendingRequests->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>
@endsection





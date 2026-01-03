<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed z-40 inset-y-0 left-0 w-64 bg-white shadow-xl transform transition-transform duration-300 ease-in-out border-r border-gray-200">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-primary">BelajarMate</h2>
            <p class="text-sm text-gray-500 mt-1">Admin Portal</p>
        </div>
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <nav class="p-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span>Manage Users</span>
        </a>
        <a href="{{ route('admin.blog-moderation.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.blog-moderation*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span>Blog Moderation</span>
        </a>
        <!-- <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span>Reports</span>
        </a> -->
        <a href="{{ route('admin.data.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.data*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
            </svg>
            <span>List Data</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.analytics*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-purple-50' }} font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Analytics</span>
        </a>
    </nav>

    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center space-x-3 px-4 py-3">
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                A
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-800 truncate">Admin User</p>
                <p class="text-xs text-gray-500 truncate">admin@belajarmate.com</p>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay for sidebar -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black bg-opacity-30 z-30"
     x-cloak></div>

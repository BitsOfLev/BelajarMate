@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Manage Users</h2>

        <div class="flex gap-3">
            <!-- Export button -->
            <button class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                Export Users
            </button>
        </div>
    </div>

    <!-- Search & Role Filter -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 items-center mb-4">
        <input type="text" name="search" placeholder="Search by ID or Name" value="{{ request('search') }}" class="px-3 py-1 border rounded-md focus:ring focus:ring-primary">

        <select name="role" class="px-2 py-1 border rounded-md">
            <option value="all" {{ request('role') == 'all' || !request('role') ? 'selected' : '' }}>All Roles</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Users</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
        </select>

        <button type="submit" class="px-3 py-1 bg-primary text-white rounded-md hover:bg-purple-700 transition-colors">Filter</button>
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Join Date</th>
                    <th class="px-4 py-2 border">Total Blogs</th>
                    <th class="px-4 py-2 border">Total Comments</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span>{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-2 border">
                        @if($user->role === 'admin')
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-medium">Admin</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">User</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2 border text-center">{{ $user->blogs()->count() }}</td>
                    <td class="px-4 py-2 border text-center">{{ $user->blogComments()->count() }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex gap-2 flex-wrap">
                            <!-- View Details (for moderation) -->
                            <a href="{{ route('admin.users.show', $user->id) }}" 
                            class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                View Details
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection



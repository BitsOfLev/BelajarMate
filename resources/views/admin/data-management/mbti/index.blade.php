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
    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">MBTI Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage and review MBTI types</p>
        </div>
        <div>
            <a href="{{ route('admin.data-management.mbti.create') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 shadow-sm">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
               </svg>
               Add MBTI
            </a>
        </div>
    </div>

    <!-- MBTI Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mt-4">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mbtis as $mbti)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            #{{ $mbti->mbtiID }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $mbti->mbti }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.data-management.mbti.edit', $mbti->mbtiID) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.data-management.mbti.destroy', $mbti->mbtiID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this MBTI type?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-12 text-center text-gray-500">
                            No MBTI types found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mbtis->hasPages())
        <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            {{ $mbtis->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>

<!-- Custom styles for pagination -->
<style>
    nav[role="navigation"] {
        @apply flex items-center justify-between;
    }
    nav[role="navigation"] .hidden {
        @apply sm:flex;
    }
</style>
@endsection



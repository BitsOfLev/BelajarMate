@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-4">

    <!-- Back button -->
    <a href="{{ route('admin.data-management.mbti.index') }}" 
        class="inline-flex items-center gap-3 px-4 py-2.5">
        <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-full shadow-sm hover:shadow-lg hover:bg-gray-800 transition-all cursor-pointer">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </div>
        <span class="font-bold text-gray-800 text-base">Back to MBTI List</span>
    </a>

    <!-- Page Header -->
    <div class="flex justify-between items-center flex-wrap gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Add MBTI Type</h2>
        <p class="text-sm text-gray-500 mt-1">Create a new MBTI type</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.data-management.mbti.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- MBTI Type -->
            <div>
                <label for="mbti" class="block text-sm font-medium text-gray-700 mb-1">MBTI Type</label>
                <input type="text" 
                       name="mbti" 
                       id="mbti"
                       value="{{ old('mbti') }}" 
                       placeholder="Enter MBTI type (e.g., INTJ)"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('mbti')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                    Add MBTI
                </button>
                <a href="{{ route('admin.data-management.mbti.index') }}" 
                   class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection

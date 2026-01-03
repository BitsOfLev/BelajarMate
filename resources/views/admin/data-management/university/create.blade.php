@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Add New University</h2>
        <a href="{{ route('admin.data-management.university.index') }}" 
           class="px-3 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
           Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.data-management.university.store') }}" method="POST">
            @csrf

            <!-- University Name -->
            <div class="mb-4">
                <label for="uniName" class="block text-gray-700 font-medium mb-1">University Name</label>
                <input type="text" name="uniName" id="uniName" value="{{ old('uniName') }}"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary"
                       placeholder="Enter university name" required>
            </div>

            <!-- Submitted By (optional display, auto-set in controller) -->
            {{-- <input type="hidden" name="submitted_by" value="{{ auth()->id() }}"> --}}

            <!-- Approval Status (hidden, default to pending) -->
            <input type="hidden" name="approval_status" value="pending">

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Add University
                </button>
                <a href="{{ route('admin.data-management.university.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                   Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection


@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Edit University</h2>
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

        <form action="{{ route('admin.data-management.university.update', $university->uniID) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- University Name -->
            <div class="mb-4">
                <label for="uniName" class="block text-gray-700 font-medium mb-1">University Name</label>
                <input type="text" name="uniName" id="uniName" 
                       value="{{ old('uniName', $university->uniName) }}"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary"
                       placeholder="Enter university name" required>
            </div>

            <!-- Optional: Approval Status -->
            <div class="mb-4">
                <label for="approval_status" class="block text-gray-700 font-medium mb-1">Approval Status</label>
                <select name="approval_status" id="approval_status" 
                        class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-primary">
                    <option value="pending" {{ $university->approval_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $university->approval_status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $university->approval_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Update University
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


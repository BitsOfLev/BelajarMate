@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white rounded-lg shadow p-6 border border-gray-200 space-y-4">
        @csrf
        @method('PATCH')

        <!-- Email -->
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <!-- University -->
        <select name="uniID" class="w-full px-3 py-2 border rounded-md">
            <option value="">-- Select University --</option>
            @foreach($universities as $uni)
                <option value="{{ $uni->id }}" 
                    {{ (string) old('uniID', $user->userInfo->uniID ?? '') === (string) $uni->id ? 'selected' : '' }}>
                    {{ $uni->name }}
                </option>
            @endforeach
        </select>

        <!-- Course -->
        <select name="courseID" class="w-full px-3 py-2 border rounded-md">
            <option value="">-- Select Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" 
                    {{ (string) old('courseID', $user->userInfo->courseID ?? '') === (string) $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>

        <!-- Education Level -->
        <select name="edulvlID" class="w-full px-3 py-2 border rounded-md">
            <option value="">-- Select Education Level --</option>
            @foreach($educationLevels as $level)
                <option value="{{ $level->id }}" 
                    {{ (string) old('edulvlID', $user->userInfo->edulvlID ?? '') === (string) $level->id ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>

        <!-- Academic Year -->
        <input type="text" name="academicYear" 
            value="{{ old('academicYear', $user->userInfo->academicYear ?? '') }}" 
            class="w-full px-3 py-2 border rounded-md">



        <!-- Submit -->
        <div class="flex gap-2">
            <button type="submit" class="px-3 py-2 bg-primary text-white rounded-md hover:bg-purple-700">
                Save Changes
            </button>
            <a href="{{ route('admin.users.show', $user->id) }}" 
               class="px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
               Cancel
            </a>
        </div>
    </form>
</div>
@endsection

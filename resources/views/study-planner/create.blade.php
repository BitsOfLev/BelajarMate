@extends('layouts.main')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <div class="card p-4 shadow-sm border-0 rounded-4">
        <h5 class="fw-semibold mb-3" style="color:#8c52ff;">Create New Study Planner</h5>

        <form action="{{ route('study-planner.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="studyPlanName" class="form-label small">Planner Title</label>
                <input type="text" name="studyPlanName" class="form-control rounded-3 shadow-sm" placeholder="Enter planner name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label small">Description</label>
                <textarea name="description" class="form-control rounded-3 shadow-sm" rows="3" placeholder="Briefly describe this planner"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label small">Category</label>
                    <select name="category_id" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label small">Priority</label>
                    <select name="priority" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select</option>
                        <option>High</option>
                        <option>Medium</option>
                        <option>Low</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label small">Start Date</label>
                    <input type="date" name="start_date" class="form-control rounded-3 shadow-sm">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label small">Due Date</label>
                    <input type="date" name="due_date" class="form-control rounded-3 shadow-sm">
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn rounded-pill text-white px-4" style="background-color: #8c52ff;">Save Planner</button>
                <a href="{{ route('study-planner.index') }}" class="btn rounded-pill px-4 border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection





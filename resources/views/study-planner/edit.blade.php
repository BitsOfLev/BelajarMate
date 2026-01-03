@extends('layouts.main')

@section('content')
<div class="container py-4">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <div class="card p-4 shadow-sm border-0 rounded-4">
        <h4 class="fw-bold mb-3">Edit Study Planner</h4>

        <form method="POST" action="{{ route('study-planner.update', $studyPlanner->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="studyPlanName" class="form-label fw-semibold">Planner Name</label>
                <input type="text" name="studyPlanName" class="form-control rounded-3 py-2" id="studyPlanName" 
                       value="{{ old('studyPlanName', $studyPlanner->studyPlanName) }}" required>
                <div class="invalid-feedback">Please enter a planner name.</div>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select rounded-3 py-2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $studyPlanner->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label fw-semibold">Priority</label>
                <select name="priority" class="form-select rounded-3 py-2" required>
                    <option value="">Select</option>
                    @foreach(['High','Medium','Low'] as $pri)
                        <option value="{{ $pri }}" {{ $studyPlanner->priority == $pri ? 'selected' : '' }}>{{ $pri }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" class="form-control rounded-3 py-2" rows="4"
                          placeholder="Describe your study planner...">{{ old('description', $studyPlanner->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="start_date" class="form-control rounded-3" value="{{ $studyPlanner->start_date }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label fw-semibold">Due Date</label>
                    <input type="date" name="due_date" class="form-control rounded-3" value="{{ $studyPlanner->due_date }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('study-planner.show', $studyPlanner->id) }}" class="btn rounded-pill px-4 py-2 btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn rounded-pill px-4 py-2 text-white fw-semibold"
                        style="background-color:#8c52ff;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>
@endsection



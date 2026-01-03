@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    .detail-container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Main Card */
    .planner-detail-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
    }

    /* Header Section */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .badge-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-category {
        background: #f3f4f6;
        color: #4b5563;
    }

    .badge-priority {
        color: white;
    }

    .detail-dates {
        display: flex;
        gap: 24px;
        font-size: 0.813rem;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
    }

    .date-info strong {
        color: #374151;
        font-weight: 600;
    }

    .alert-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 50px;
        font-size: 0.688rem;
        font-weight: 600;
        margin-left: 6px;
    }

    .alert-overdue { background: #fee2e2; color: #991b1b; }
    .alert-today { background: #fef3c7; color: #78350f; }
    .alert-soon { background: #dbeafe; color: #1e40af; }

    .description-section {
        margin-bottom: 16px;
        padding: 14px;
        background: #f9fafb;
        border-radius: 8px;
    }

    .description-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .description-text {
        font-size: 0.875rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }

    /* Progress Section */
    .progress-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #f9fafb 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e0f2fe;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .progress-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
    }

    .progress-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--bm-purple);
    }

    .progress-bar-wrapper {
        height: 10px;
        background: #e5e7eb;
        border-radius: 50px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progress-bar-fill {
        height: 100%;
        background: var(--bm-purple);
        border-radius: 50px;
        transition: width 0.5s ease;
    }

    .progress-bar-fill.completed {
        background: #22c55e;
    }

    .progress-tasks {
        font-size: 0.813rem;
        color: #6b7280;
    }

    .progress-tasks strong {
        color: #111827;
        font-weight: 700;
    }

    /* Tasks Section */
    .tasks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .tasks-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .task-count-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }


    /* Filter Buttons */
    .filter-group {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
    }

    .filter-btn {
        padding: 6px 14px;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .filter-btn.active {
        background: var(--bm-purple);
        border-color: var(--bm-purple);
        color: white;
    }

    /* Task List */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .task-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
    }

    .task-item:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .task-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .task-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #22c55e;
    }

    .task-name {
        font-size: 0.875rem;
        color: #111827;
        font-weight: 500;
    }

    .task-name.completed {
        color: #9ca3af;
        text-decoration: line-through;
    }

    .task-actions {
        display: flex;
        gap: 6px;
    }

    .task-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: #f9fafb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
    }

    .task-btn:hover {
        background: #f3f4f6;
    }

    .task-btn.edit:hover {
        background: #eff6ff;
        color: #3b82f6;
    }

    .task-btn.delete:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f9fafb;
        border-radius: 10px;
        border: 1px dashed #d1d5db;
    }

    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .empty-text {
        font-size: 0.875rem;
        color: #9ca3af;
        margin-bottom: 20px;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid #f3f4f6;
        padding: 20px 24px;
    }

    .modal-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--bm-purple);
    }

    .modal-body {
        padding: 24px;
    }

    .form-label {
        font-size: 0.813rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .modal-footer {
        border-top: 1px solid #f3f4f6;
        padding: 16px 24px;
        gap: 8px;
    }

    .btn-cancel {
        padding: 8px 20px;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        font-size: 0.813rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f9fafb;
    }

    .btn-submit {
        padding: 8px 20px;
        border-radius: 50px;
        border: none;
        background: var(--bm-purple);
        color: white;
        font-size: 0.813rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: var(--bm-purple-dark);
    }

    /* Save Notification */
    .save-notification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        display: none;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        z-index: 9999;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
        font-size: 0.875rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
    }

    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
    }
</style>

<div class="container py-4">
    <div class="detail-container">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0" style="padding-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('study-planner.index') }}" class="bm-back-btn">
            <div class="bm-back-icon">
                <i class="bi bi-arrow-left"></i>
            </div>
            <span>Back</span>
        </a>

        <!-- Main Card -->
        <div class="planner-detail-card">
            <!-- Header -->
            <div class="detail-header">
                <div>
                    <h1 class="detail-title">{{ $studyPlanner->studyPlanName }}</h1>
                    
                    <div class="badge-group">
                        <span class="badge badge-category">
                            {{ $studyPlanner->category?->name ?? 'Uncategorized' }}
                        </span>
                        @php
                            $priorityColors = ['High' => '#dc2626', 'Medium' => '#ea580c', 'Low' => '#22c55e'];
                            $priorityColor = $priorityColors[$studyPlanner->priority] ?? '#6b7280';
                        @endphp
                        <span class="badge badge-priority" style="background-color: {{ $priorityColor }};">
                            {{ $studyPlanner->priority ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="detail-dates">
                        @php
                            $startDate = $studyPlanner->start_date ? \Carbon\Carbon::parse($studyPlanner->start_date)->format('M d, Y') : null;
                            $dueDate = $studyPlanner->due_date ? \Carbon\Carbon::parse($studyPlanner->due_date)->format('M d, Y') : null;
                            $daysUntilDue = $studyPlanner->due_date ? now()->diffInDays(\Carbon\Carbon::parse($studyPlanner->due_date), false) : null;
                        @endphp
                        <div class="date-info">
                            <span>Start:</span>
                            <strong>{{ $startDate ?? 'Not set' }}</strong>
                        </div>
                        <div class="date-info">
                            <span>Due:</span>
                            <strong>{{ $dueDate ?? 'Not set' }}</strong>
                            @if($daysUntilDue !== null)
                                @if($daysUntilDue < 0)
                                    <span class="alert-badge alert-overdue">Overdue</span>
                                @elseif($daysUntilDue == 0)
                                    <span class="alert-badge alert-today">Due Today</span>
                                @elseif($daysUntilDue <= 7)
                                    <span class="alert-badge alert-soon">{{ ceil($daysUntilDue) }}d left</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('study-planner.edit', $studyPlanner->id) }}" class="btn-edit">
                    <span>Edit</span>
                </a>
            </div>

            <!-- Description -->
            @if($studyPlanner->description)
            <div class="description-section">
                <div class="description-label">Description</div>
                <p class="description-text">{{ $studyPlanner->description }}</p>
            </div>
            @endif

            <!-- Progress -->
            @php
                $isComplete = $studyPlanner->total_tasks > 0 && $studyPlanner->completed_tasks === $studyPlanner->total_tasks;
                $progressPercent = $studyPlanner->total_tasks > 0 ? round(($studyPlanner->completed_tasks / $studyPlanner->total_tasks) * 100) : 0;
            @endphp
            <div class="progress-card">
                <div class="progress-header">
                    <span class="progress-label">Overall Progress</span>
                    <span class="progress-value" id="progressPercentage">{{ $progressPercent }}%</span>
                </div>
                <div class="progress-bar-wrapper">
                    <div id="progressBar" class="progress-bar-fill {{ $isComplete ? 'completed' : '' }}" 
                         style="width: {{ $progressPercent }}%;"></div>
                </div>
                <div class="progress-tasks" id="taskCount">
                    <strong>{{ $studyPlanner->completed_tasks }}</strong> of <strong>{{ $studyPlanner->total_tasks }}</strong> tasks completed
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="tasks-header">
                <h2 class="tasks-title">
                    Tasks
                    <span class="task-count-badge">{{ $tasks->count() }}</span>
                </h2>
                <button class="btn-create" onclick="openAddTaskModal()">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add Task</span>
                </button>
            </div>

            <!-- Filter -->
            <div class="filter-group">
                <button class="filter-btn active" data-filter="all">
                    All (<span id="countAll">{{ $tasks->count() }}</span>)
                </button>
                <button class="filter-btn" data-filter="active">
                    Active (<span id="countActive">{{ $tasks->where('taskStatus', false)->count() }}</span>)
                </button>
                <button class="filter-btn" data-filter="completed">
                    Completed (<span id="countCompleted">{{ $tasks->where('taskStatus', true)->count() }}</span>)
                </button>
            </div>

            <!-- Task List -->
            <div class="task-list" id="taskList">
                @forelse($tasks as $task)
                <div class="task-item" id="task-{{ $task->id }}" data-status="{{ $task->taskStatus ? 'completed' : 'active' }}">
                    <div class="task-left">
                        <input class="task-checkbox" type="checkbox" 
                               onchange="toggleTask({{ $task->id }})" 
                               {{ $task->taskStatus ? 'checked' : '' }}>
                        <span class="task-name {{ $task->taskStatus ? 'completed' : '' }}">
                            {{ $task->taskName }}
                        </span>
                    </div>
                    <div class="task-actions">
                        <button class="task-btn edit" 
                                onclick="editTask({{ $task->id }}, '{{ addslashes($task->taskName) }}')"
                                title="Edit task">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('study-task.destroy', $task->id) }}" 
                              onsubmit="return confirm('Delete this task?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="task-btn delete" title="Delete task">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h3 class="empty-title">No tasks yet</h3>
                    <p class="empty-text">Get started by adding your first task!</p>
                    <button class="btn-add-task" onclick="openAddTaskModal()">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Your First Task</span>
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <form id="taskForm" method="POST" action="{{ route('study-task.store', $studyPlanner->id) }}">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="taskNameInput" class="form-label">Task Name</label>
                    <input type="text" name="task_name" id="taskNameInput" 
                           class="form-control" 
                           placeholder="e.g., Read Chapter 5" 
                           required autofocus>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">
                        <span id="submitBtnText">Save</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Save Notification -->
<div class="save-notification" id="saveNotification">
    <i class="bi bi-check-circle-fill"></i>
    <span>Changes saved!</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
    const taskForm = document.getElementById('taskForm');
    const taskNameInput = document.getElementById('taskNameInput');
    const methodField = document.getElementById('methodField');

    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const tasks = document.querySelectorAll('.task-item');
            
            tasks.forEach(task => {
                const status = task.dataset.status;
                if (filter === 'all' || status === filter) {
                    task.style.display = 'flex';
                } else {
                    task.style.display = 'none';
                }
            });
        });
    });

    // Show save notification
    function showSaveNotification() {
        const notification = document.getElementById('saveNotification');
        notification.style.display = 'flex';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 2000);
    }

    // Update filter counts
    function updateFilterCounts() {
        const allTasks = document.querySelectorAll('.task-item');
        const activeTasks = document.querySelectorAll('.task-item[data-status="active"]');
        const completedTasks = document.querySelectorAll('.task-item[data-status="completed"]');
        
        document.getElementById('countAll').textContent = allTasks.length;
        document.getElementById('countActive').textContent = activeTasks.length;
        document.getElementById('countCompleted').textContent = completedTasks.length;
    }

    // Open Add Task Modal
    window.openAddTaskModal = function() {
        taskForm.action = "{{ route('study-task.store', $studyPlanner->id) }}";
        methodField.value = "POST";
        document.getElementById('taskModalLabel').textContent = "Add Task";
        document.getElementById('submitBtnText').textContent = "Save";
        taskNameInput.value = "";
        taskModal.show();
        setTimeout(() => taskNameInput.focus(), 300);
    };

    // Open Edit Task Modal
    window.editTask = function(id, name) {
        taskForm.action = `/tasks/${id}`;
        methodField.value = "PUT";
        document.getElementById('taskModalLabel').textContent = "Edit Task";
        document.getElementById('submitBtnText').textContent = "Update";
        taskNameInput.value = name;
        taskModal.show();
        setTimeout(() => taskNameInput.focus(), 300);
    };

    // Toggle task completion
    window.toggleTask = function(id){
        const taskItem = document.getElementById('task-' + id);
        const checkbox = taskItem.querySelector('input[type="checkbox"]');
        const taskText = taskItem.querySelector('.task-name');
        
        fetch(`/tasks/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Update UI
            checkbox.checked = data.completed;
            
            if (data.completed) {
                taskText.classList.add('completed');
                taskItem.dataset.status = 'completed';
            } else {
                taskText.classList.remove('completed');
                taskItem.dataset.status = 'active';
            }
            
            // Update progress
            const progressBar = document.getElementById('progressBar');
            const progressPercentage = document.getElementById('progressPercentage');
            const taskCount = document.getElementById('taskCount');
            
            progressBar.style.width = data.progress + '%';
            progressPercentage.textContent = data.progress + '%';
            
            const total = {{ $studyPlanner->total_tasks }};
            const completed = Math.round(total * data.progress / 100);
            taskCount.innerHTML = `<strong>${completed}</strong> of <strong>${total}</strong> tasks completed`;
            
            // Update progress bar color
            if (data.progress === 100) {
                progressBar.classList.add('completed');
            } else {
                progressBar.classList.remove('completed');
            }

            // Update filter counts
            updateFilterCounts();

            // Reapply current filter
            const activeFilter = document.querySelector('.filter-btn.active');
            if (activeFilter) {
                activeFilter.click();
            }

            // Show notification
            showSaveNotification();
        })
        .catch(err => {
            console.error('Toggle error:', err);
            checkbox.checked = !checkbox.checked;
            alert('Failed to update task. Please try again.');
        });
    };

    // Auto-show modal if validation errors
    @if($errors->any() && old('task_name'))
        taskModal.show();
        taskNameInput.value = "{{ old('task_name') }}";
    @endif
});
</script>

@endsection




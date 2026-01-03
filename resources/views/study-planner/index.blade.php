@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 32px;
    }

    /* Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .stat-icon.purple { background: #f4efff; color: var(--bm-purple); }
    .stat-icon.green { background: #dcfce7; color: #16a34a; }
    .stat-icon.orange { background: #ffedd5; color: #ea580c; }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }

    /* Control Panel */
    .control-panel {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
    }

    .control-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .control-label {
        font-size: 0.813rem;
        font-weight: 600;
        color: #6b7280;
        white-space: nowrap;
    }

    .control-select {
        min-width: 160px;
        border: 1px solid #e5e7eb;
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.813rem;
        background: #f8f9fa;
        color: #1f2937;
        transition: all 0.2s;
    }

    .control-select:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .toggle-label {
        font-size: 0.813rem;
        font-weight: 600;
        color: #6b7280;
    }

    /* Planner List */
    .planner-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* Planner Card - Vertical Layout */
    .planner-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .planner-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    .planner-card.completed {
        border-left: 4px solid #22c55e;
        background: linear-gradient(to right, #f0fdf4 0%, white 2%);
    }

    /* Card Header - Title & Actions */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .planner-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
        flex: 1;
        margin-right: 12px;
    }

    .card-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #f9fafb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.938rem;
        position: relative;
    }

    .btn-action:hover {
        background: #f3f4f6;
    }

    .btn-action.view:hover {
        color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }

    .btn-action.edit:hover {
        color: #3b82f6;
        background: #eff6ff;
    }

    .btn-action.delete:hover {
        color: #dc2626;
        background: #fef2f2;
    }

    .btn-action::after {
        content: attr(data-tip);
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 3px 9px;
        border-radius: 5px;
        font-size: 0.688rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 10;
    }

    .btn-action:hover::after {
        opacity: 1;
    }

    /* Badges */
    .badge-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .badge {
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-category {
        background: #f3f4f6;
        color: #4b5563;
    }

    .badge-priority {
        color: white;
    }

    .badge-completed {
        background: #dcfce7;
        color: #16a34a;
    }

    /* Progress Section */
    .progress-section {
        margin-bottom: 16px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    .progress-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: #111827;
    }

    .progress-bar-wrapper {
        height: 6px;
        background: #f3f4f6;
        border-radius: 50px;
        overflow: hidden;
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

    /* Dates Section */
    .dates-section {
        display: flex;
        justify-content: space-between;
        font-size: 0.813rem;
        color: #6b7280;
    }

    .date-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .date-label {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .date-value {
        font-weight: 600;
        color: #374151;
    }

    .alert-badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 50px;
        font-size: 0.625rem;
        font-weight: 600;
        margin-left: 5px;
    }

    .alert-overdue { background: #fee2e2; color: #991b1b; }
    .alert-today { background: #fef3c7; color: #78350f; }
    .alert-soon { background: #dbeafe; color: #1e40af; }

    /* Group Sections */
    .group-section {
        margin-bottom: 36px;
    }

    .group-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .group-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .group-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Empty State */
    .empty-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
    }

    .empty-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .empty-icon-circle i {
        font-size: 2rem;
        color: #d1d5db;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #9ca3af;
        font-size: 0.938rem;
        margin-bottom: 24px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .control-row {
            flex-direction: column;
            align-items: stretch;
        }

        .control-group {
            width: 100%;
        }

        .control-select {
            width: 100%;
        }

        .toggle-wrapper {
            margin-left: 0;
            justify-content: space-between;
        }

        .stats-bar {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">My Study Planners</h3>
        <p class="page-subtitle">Organize, track, and achieve your academic goals</p>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar" id="statsBar">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Planners</div>
                    <div class="stat-value" id="totalCount">0</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value" id="completedCount">0</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value" id="inProgressCount">0</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Panel -->
    <div class="control-panel">
        <div class="control-row">
            <div class="control-group">
                <span class="control-label">Group by</span>
                <select class="control-select" id="filterDropdown" onchange="applyFilters()">
                    <option value="">None</option>
                    <option value="status">Status</option>
                    <option value="category">Category</option>
                    <option value="priority">Priority</option>
                </select>
            </div>

            <div class="control-group">
                <span class="control-label">Sort by</span>
                <select class="control-select" id="sortDropdown" onchange="applyFilters()">
                    <option value="created_desc">Newest First</option>
                    <option value="created_asc">Oldest First</option>
                    <option value="due_asc">Due Soon</option>
                    <option value="due_desc">Due Later</option>
                    <option value="progress_desc">Most Progress</option>
                    <option value="progress_asc">Least Progress</option>
                </select>
            </div>

            <div class="toggle-wrapper">
                <span class="toggle-label">Show Completed</span>
                <input type="checkbox" id="showCompletedToggle" checked onchange="applyFilters()">
            </div>

            <a href="{{ route('study-planner.create') }}" class="btn-create">
                <i class="bi bi-plus-lg"></i>
                <span>New Planner</span>
            </a>
        </div>
    </div>

    <!-- Empty State -->
    <div class="empty-container" id="emptyState" style="display:none;">
        <div class="empty-icon-circle">
            <i class="bi bi-clipboard-check"></i>
        </div>
        <h3 class="empty-title">No planners yet</h3>
        <p class="empty-text">Create your first study planner to start organizing your academic journey</p>
        <a href="{{ route('study-planner.create') }}" class="btn-create">
            <i class="bi bi-plus-lg"></i>
            <span>Create Your First Planner</span>
        </a>
    </div>

    <!-- Planner Container -->
    <div id="plannerContainer"></div>
</div>

<script>
    const planners = @json($planners);
    
    const priorityConfig = {
        High: '#dc2626',
        Medium: '#ea580c',
        Low: '#22c55e'
    };

    function formatDate(dateString) {
        if (!dateString) return 'Not set';
        const date = new Date(dateString);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function getDaysUntilDue(dueDate) {
        if (!dueDate) return null;
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const due = new Date(dueDate);
        due.setHours(0, 0, 0, 0);
        return Math.ceil((due - today) / (1000 * 60 * 60 * 24));
    }

    function getAlertBadge(dueDate) {
        const days = getDaysUntilDue(dueDate);
        if (days === null) return '';
        
        if (days < 0) return `<span class="alert-badge alert-overdue">Overdue</span>`;
        if (days === 0) return `<span class="alert-badge alert-today">Due Today</span>`;
        if (days <= 7) return `<span class="alert-badge alert-soon">${days}d left</span>`;
        return '';
    } 

    function isComplete(planner) {
        return planner.total_tasks > 0 && planner.completed_tasks === planner.total_tasks;
    }

    function updateStats() {
        const total = planners.length;
        const completed = planners.filter(p => isComplete(p)).length;
        const inProgress = total - completed;

        document.getElementById('totalCount').textContent = total;
        document.getElementById('completedCount').textContent = completed;
        document.getElementById('inProgressCount').textContent = inProgress;
    }

    function renderCard(planner) {
        const progress = planner.total_tasks > 0 ? Math.round((planner.completed_tasks / planner.total_tasks) * 100) : 0;
        const priority = planner.priority || 'N/A';
        const priorityColor = priorityConfig[priority] || '#6b7280';
        const category = planner.category?.name ?? 'Uncategorized';
        const complete = isComplete(planner);
        const startAlert = getAlertBadge(planner.start_date);
        const dueAlert = getAlertBadge(planner.due_date);

        return `
            <div class="planner-card ${complete ? 'completed' : ''}">
                <!-- Header: Title & Actions -->
                <div class="card-header">
                    <h3 class="planner-title">${planner.studyPlanName}</h3>
                    <div class="card-actions">
                        <a href="/study-planner/${planner.id}" class="btn-action view" data-tip="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/study-planner/${planner.id}/edit" class="btn-action edit" data-tip="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/study-planner/${planner.id}" method="POST" onsubmit="return confirm('Delete this planner?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" data-tip="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Badges -->
                <div class="badge-row">
                    <span class="badge badge-category">${category}</span>
                    <span class="badge badge-priority" style="background-color: ${priorityColor};">${priority}</span>
                    ${complete ? '<span class="badge badge-completed">Completed</span>' : ''}
                </div>

                <!-- Progress -->
                <div class="progress-section">
                    <div class="progress-header">
                        <span class="progress-label">Progress</span>
                        <span class="progress-value">${progress}%</span>
                    </div>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill ${complete ? 'completed' : ''}" style="width: ${progress}%;"></div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="dates-section">
                    <div class="date-item">
                        <span class="date-label">Start Date:</span>
                        <span class="date-value">${formatDate(planner.start_date)}</span>
                    </div>
                    <div class="date-item">
                        <span class="date-label">Due Date:</span>
                        <span class="date-value">${formatDate(planner.due_date)}${dueAlert}</span>
                    </div>
                </div>
            </div>`;
    }

    function renderGroup(title, items) {
        return `
            <div class="group-section">
                <div class="group-header">
                    <h2 class="group-title">${title}</h2>
                    <span class="group-badge">${items.length}</span>
                </div>
                <div class="planner-list">
                    ${items.map(p => renderCard(p)).join('')}
                </div>
            </div>`;
    }

    function sortPlanners(items, sortBy) {
        const sorted = [...items];
        const sortFns = {
            created_asc: (a, b) => new Date(a.created_at) - new Date(b.created_at),
            created_desc: (a, b) => new Date(b.created_at) - new Date(a.created_at),
            due_asc: (a, b) => (!a.due_date ? 1 : !b.due_date ? -1 : new Date(a.due_date) - new Date(b.due_date)),
            due_desc: (a, b) => (!a.due_date ? 1 : !b.due_date ? -1 : new Date(b.due_date) - new Date(a.due_date)),
            progress_asc: (a, b) => {
                const pA = a.total_tasks > 0 ? a.completed_tasks / a.total_tasks : 0;
                const pB = b.total_tasks > 0 ? b.completed_tasks / b.total_tasks : 0;
                return pA - pB;
            },
            progress_desc: (a, b) => {
                const pA = a.total_tasks > 0 ? a.completed_tasks / a.total_tasks : 0;
                const pB = b.total_tasks > 0 ? b.completed_tasks / b.total_tasks : 0;
                return pB - pA;
            }
        };
        return sorted.sort(sortFns[sortBy] || sortFns.created_desc);
    }

    function groupBy(array, key) {
        return array.reduce((result, current) => {
            let groupKey = key === 'status' 
                ? (isComplete(current) ? 'Completed' : 'In Progress')
                : (current[key]?.name ?? current[key] ?? 'N/A');
            (result[groupKey] = result[groupKey] || []).push(current);
            return result;
        }, {});
    }

    function applyFilters() {
        const filter = document.getElementById('filterDropdown').value;
        const sortBy = document.getElementById('sortDropdown').value;
        const showCompleted = document.getElementById('showCompletedToggle').checked;
        const container = document.getElementById('plannerContainer');
        const emptyState = document.getElementById('emptyState');
        
        container.innerHTML = '';

        let filtered = showCompleted ? planners : planners.filter(p => !isComplete(p));

        if (filtered.length === 0) {
            emptyState.style.display = 'flex';
            if (!showCompleted && planners.length > 0) {
                emptyState.innerHTML = `
                    <div class="empty-icon-circle"><i class="bi bi-check-circle"></i></div>
                    <h3 class="empty-title">All planners completed!</h3>
                    <p class="empty-text">Toggle "Show Completed" to view your finished planners</p>
                `;
            }
            return;
        }

        emptyState.style.display = 'none';
        const sorted = sortPlanners(filtered, sortBy);

        if (filter === 'category') {
            const grouped = groupBy(sorted, 'category');
            Object.entries(grouped).forEach(([cat, items]) => {
                container.innerHTML += renderGroup(cat, items);
            });
        } else if (filter === 'priority') {
            const grouped = groupBy(sorted, 'priority');
            ['High', 'Medium', 'Low', 'N/A'].forEach(priority => {
                if (grouped[priority]) {
                    container.innerHTML += renderGroup(`${priority} Priority`, grouped[priority]);
                }
            });
        } else if (filter === 'status') {
            const grouped = groupBy(sorted, 'status');
            if (grouped['In Progress']) container.innerHTML += renderGroup('In Progress', grouped['In Progress']);
            if (grouped['Completed']) container.innerHTML += renderGroup('Completed', grouped['Completed']);
        } else {
            container.innerHTML = `<div class="planner-list">${sorted.map(p => renderCard(p)).join('')}</div>`;
        }
    }

    updateStats();
    applyFilters();
</script>
@endsection










@extends('layouts.main')

@section('content')

<style>
    /* Pomodoro Styles */
    .page-header { margin-bottom: 32px; }
    
    /* Tab Navigation */
    .tab-navigation {
        background: white;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }
    .tab-list { display: flex; border-bottom: 1px solid #e5e7eb; }
    .tab-button {
        flex: 1;
        padding: 16px 20px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-size: 0.938rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab-button:hover { color: var(--bm-purple); background: #fafbfc; }
    .tab-button.active {
        color: var(--bm-purple);
        border-bottom-color: var(--bm-purple);
        background: #fafbfc;
    }
    .tab-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        padding: 2px 8px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: 6px;
    }

    /* Grid Layout */
    .timer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .timer-grid { grid-template-columns: 1fr; }
    }

    /* Cards */
    .timer-card, .planner-panel, .presets-section {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
    }
    .planner-panel { padding: 24px; }
    .presets-section { padding: 24px; }

    /* Selected Preset Info */
    .selected-preset-info {
        background: var(--bm-purple-lighter);
        border: 1px solid #e9d5ff;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 24px;
        display: none;
    }
    .selected-preset-info.active { display: block; }
    .preset-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .preset-info-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--bm-purple);
    }
    .preset-info-details {
        font-size: 0.813rem;
        color: #6b21a8;
        margin-top: 4px;
    }
    .btn-change {
        background: white;
        border: 1px solid #e9d5ff;
        color: var(--bm-purple);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.813rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-change:hover {
        background: var(--bm-purple);
        color: white;
    }

    /* Timer Display */
    .timer-display-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 0;
    }
    .circular-timer {
        position: relative;
        margin-bottom: 32px;
    }
    .timer-time {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    .time-display {
        font-size: 3.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }
    .phase-display {
        font-size: 0.938rem;
        color: #6b7280;
        margin-top: 8px;
        font-weight: 500;
    }
    .cycle-display {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
    }

    /* Timer Controls */
    .timer-controls {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }
    .btn-timer {
        padding: 12px 32px;
        border-radius: 10px;
        border: none;
        font-size: 0.938rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-timer:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-timer.primary {
        background: var(--bm-purple);
        color: white;
    }
    .btn-timer.primary:hover:not(:disabled) {
        background: #7c3aed;
    }
    .btn-timer.warning {
        background: #f59e0b;
        color: white;
    }
    .btn-timer.warning:hover:not(:disabled) {
        background: #d97706;
    }
    .btn-timer.success {
        background: #10b981;
        color: white;
    }
    .btn-timer.success:hover:not(:disabled) {
        background: #059669;
    }
    .btn-timer.secondary {
        background: #f3f4f6;
        color: #374151;
    }
    .btn-timer.secondary:hover:not(:disabled) {
        background: #e5e7eb;
    }

    /* Session Stats */
    .session-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        width: 100%;
        max-width: 500px;
    }
    .stat-box {
        background: #fafbfc;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
    }
    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        line-height: 1;
    }
    .stat-value.purple { color: var(--bm-purple); }
    .stat-value.green { color: #10b981; }
    .stat-value.blue { color: #3b82f6; }
    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 4px;
    }

    /* Planner Panel */
    .panel-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .control-select {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
        margin-bottom: 16px;
        transition: all 0.2s;
    }
    .control-select:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 16px;
    }
    .task-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #fafbfc;
        border-radius: 8px;
        border: 1px solid #f3f4f6;
        transition: all 0.2s;
    }
    .task-item:hover {
        background: #f3f4f6;
    }
    .task-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--bm-purple);
    }
    .task-item label {
        flex: 1;
        font-size: 0.875rem;
        color: #374151;
        cursor: pointer;
    }
    .task-item.completed label {
        text-decoration: line-through;
        color: #9ca3af;
    }
    .empty-tasks {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }
    .empty-tasks i {
        font-size: 2.5rem;
        color: #d1d5db;
        margin-bottom: 12px;
        display: block;
    }

    /* Preset Grid */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
    }
    .preset-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .preset-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .preset-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    .preset-card.selected {
        border-color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }
    .preset-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .preset-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: inline-block;
    }
    .preset-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
    }
    .preset-icon {
        width: 40px;
        height: 40px;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .preset-details {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
        font-size: 0.875rem;
    }
    .preset-row {
        display: flex;
        justify-content: space-between;
        color: #6b7280;
    }
    .preset-row span:last-child {
        font-weight: 600;
        color: #111827;
    }
    .preset-actions {
        display: flex;
        gap: 8px;
    }
    .btn-preset-select {
        flex: 1;
        background: var(--bm-purple);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-preset-select:hover {
        background: #7c3aed;
    }

    /* Empty State */
    .empty-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }
    .empty-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .empty-icon-circle i {
        font-size: 2rem;
        color: #d1d5db;
    }
    .empty-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }
    .empty-text {
        color: #9ca3af;
        font-size: 0.875rem;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Alert */
    .alert {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="container py-4">
    {{-- Page Header --}}
    <div class="page-header">
        <h3 class="page-title">Pomodoro Timer</h3>
        <p class="page-subtitle">Stay focused and productive with structured work sessions</p>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Tab Navigation --}}
    <div class="tab-navigation">
        <div class="tab-list">
            <button onclick="switchTab('system')" id="tab-system" class="tab-button active">
                System Presets
            </button>
            <button onclick="switchTab('custom')" id="tab-custom" class="tab-button">
                My Presets
                <span class="tab-badge">{{ $userPresets->count() }}/3</span>
            </button>
        </div>
    </div>

    {{-- Main Timer & Planner Grid --}}
    <div class="timer-grid">
        
        {{-- Timer Section --}}
        <div class="timer-card">
            {{-- Selected Preset Info --}}
            <div id="selected-preset-info" class="selected-preset-info">
                <div class="preset-info-header">
                    <div>
                        <div class="preset-info-title" id="selected-preset-title">Classic Pomodoro</div>
                        <div class="preset-info-details" id="selected-preset-details">
                            25min work • 5min short break • 15min long break
                        </div>
                    </div>
                    <button onclick="clearSelection()" class="btn-change">Change</button>
                </div>
            </div>

            {{-- Timer Display --}}
            <div class="timer-display-wrapper">
                <div class="circular-timer">
                    <svg width="280" height="280" style="transform: rotate(-90deg);">
                        <circle cx="140" cy="140" r="120" stroke="#f3f4f6" stroke-width="12" fill="none"/>
                        <circle id="progress-circle" cx="140" cy="140" r="120" 
                            stroke="#9333ea" stroke-width="12" fill="none"
                            stroke-linecap="round"
                            style="stroke-dasharray: 754; stroke-dashoffset: 754; transition: stroke-dashoffset 1s linear, stroke 0.3s;"/>
                    </svg>
                    
                    <div class="timer-time">
                        <div class="time-display" id="timer-display">25:00</div>
                        <div class="phase-display" id="phase-display">Select a preset to start</div>
                        <div class="cycle-display" id="cycle-display" style="display: none;">Cycle 1 of 4</div>
                    </div>
                </div>

                {{-- Timer Controls --}}
                <div class="timer-controls">
                    <button id="start-btn" onclick="startTimer()" disabled class="btn-timer primary">Start</button>
                    <button id="pause-btn" onclick="pauseTimer()" disabled class="btn-timer warning" style="display: none;">Pause</button>
                    <button id="resume-btn" onclick="resumeTimer()" disabled class="btn-timer success" style="display: none;">Resume</button>
                    <button id="reset-btn" onclick="resetTimer()" disabled class="btn-timer secondary">Reset</button>
                </div>

                {{-- Session Stats --}}
                <div id="session-stats" class="session-stats" style="display: none;">
                    <div class="stat-box">
                        <div class="stat-value purple" id="cycles-completed">0</div>
                        <div class="stat-label">Cycles</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value green" id="focus-minutes">0</div>
                        <div class="stat-label">Focus Min</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value blue" id="break-minutes">0</div>
                        <div class="stat-label">Break Min</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Planner Integration --}}
        <div class="planner-panel">
            <h3 class="panel-title">
                <i class="bi bi-clipboard-check"></i>
                Study Tasks
            </h3>

            {{-- Planner Selector --}}
            <select id="planner-selector" class="control-select" onchange="loadPlannerTasks(this.value)">
                <option value="">Select a planner (optional)</option>
                @foreach($planners as $planner)
                    <option value="{{ $planner->id }}">{{ $planner->studyPlanName }}</option>
                @endforeach
            </select>

            {{-- Task List --}}
            <div id="task-list">
                <div class="empty-tasks">
                    <i class="bi bi-journal-text"></i>
                    <p>Select a planner to see tasks</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Preset Cards Section --}}
    <div class="presets-section">
        
        {{-- System Preset Tab --}}
        <div id="system-presets" class="tab-content">
            <div class="section-header">
                <h3 class="section-title">System Preset</h3>
            </div>

            @if($systemPreset)
                <div class="preset-grid">
                    <div class="preset-card" id="preset-card-{{ $systemPreset->id }}"
                        data-preset-id="{{ $systemPreset->id }}"
                        data-title="{{ $systemPreset->title }}"
                        data-work="{{ $systemPreset->work_minutes }}"
                        data-short-break="{{ $systemPreset->short_break_minutes }}"
                        data-long-break="{{ $systemPreset->long_break_minutes }}"
                        data-cycles="{{ $systemPreset->work_cycles }}"
                        onclick="selectPresetFromCard(this)">
                        
                        <div class="preset-header">
                            <div>
                                <span class="preset-badge">DEFAULT</span>
                                <div class="preset-title">{{ $systemPreset->title }}</div>
                            </div>
                            <div class="preset-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>

                        <div class="preset-details">
                            <div class="preset-row">
                                <span>Work:</span>
                                <span style="color: var(--bm-purple);">{{ $systemPreset->work_minutes }} min</span>
                            </div>
                            <div class="preset-row">
                                <span>Short Break:</span>
                                <span style="color: #3b82f6;">{{ $systemPreset->short_break_minutes }} min</span>
                            </div>
                            <div class="preset-row">
                                <span>Long Break:</span>
                                <span style="color: #10b981;">{{ $systemPreset->long_break_minutes }} min</span>
                            </div>
                            <div class="preset-row">
                                <span>Cycles:</span>
                                <span>{{ $systemPreset->work_cycles }}</span>
                            </div>
                        </div>

                        <button class="btn-preset-select" onclick="event.stopPropagation(); selectPresetFromCard(this.closest('.preset-card'));">
                            Select Preset
                        </button>
                    </div>
                </div>
            @else
                <div class="empty-container">
                    <div class="empty-icon-circle">
                        <i class="bi bi-clock"></i>
                    </div>
                    <p class="empty-text">No system preset configured</p>
                </div>
            @endif
        </div>

        {{-- Custom Presets Tab --}}
        <div id="custom-presets" class="tab-content" style="display: none;">
            <div class="section-header">
                <h3 class="section-title">My Custom Presets</h3>
                @if($userPresets->count() < 3)
                    <a href="{{ route('pomodoro.presets.create') }}" class="btn-create">
                        <i class="bi bi-plus-lg"></i>
                        <span>New Preset</span>
                    </a>
                @endif
            </div>

            @if($userPresets->count() > 0)
                <div class="preset-grid">
                    @foreach($userPresets as $preset)
                        <div class="preset-card" id="preset-card-{{ $preset->id }}"
                            data-preset-id="{{ $preset->id }}"
                            data-title="{{ $preset->title }}"
                            data-work="{{ $preset->work_minutes }}"
                            data-short-break="{{ $preset->short_break_minutes }}"
                            data-long-break="{{ $preset->long_break_minutes }}"
                            data-cycles="{{ $preset->work_cycles }}"
                            onclick="selectPresetFromCard(this)">
                            
                            <div class="preset-header">
                                <div class="preset-title">{{ $preset->title }}</div>
                                <div class="preset-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                            </div>

                            <div class="preset-details">
                                <div class="preset-row">
                                    <span>Work:</span>
                                    <span style="color: var(--bm-purple);">{{ $preset->work_minutes }} min</span>
                                </div>
                                <div class="preset-row">
                                    <span>Short Break:</span>
                                    <span style="color: #3b82f6;">{{ $preset->short_break_minutes }} min</span>
                                </div>
                                <div class="preset-row">
                                    <span>Long Break:</span>
                                    <span style="color: #10b981;">{{ $preset->long_break_minutes }} min</span>
                                </div>
                                <div class="preset-row">
                                    <span>Cycles:</span>
                                    <span>{{ $preset->work_cycles }}</span>
                                </div>
                            </div>

                            <div class="preset-actions">
                                <button onclick="event.stopPropagation(); selectPresetFromCard(this.closest('.preset-card'));" class="btn-preset-select">
                                    Select
                                </button>
                                <a href="{{ route('pomodoro.presets.edit', $preset) }}" 
                                    onclick="event.stopPropagation();"
                                    class="btn-action-secondary"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; border-radius: 8px; color: #6b7280; text-decoration: none; transition: all 0.2s;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pomodoro.presets.destroy', $preset) }}" method="POST" 
                                    onclick="event.stopPropagation();"
                                    onsubmit="return confirm('Delete this preset?');"
                                    style="margin: 0; display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #fee2e2; border-radius: 8px; background: white; color: #dc2626; cursor: pointer; transition: all 0.2s;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-container">
                    <div class="empty-icon-circle">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h3 class="empty-title">No custom presets yet</h3>
                    <p class="empty-text">Create your first preset to customize your Pomodoro sessions</p>
                    <a href="{{ route('pomodoro.presets.create') }}" class="btn-create">
                        <i class="bi bi-plus-lg"></i>
                        <span>Create First Preset</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Store planner tasks data
    const plannersData = @json($planners->load('tasks'));
    
    // Timer state
    let timerState = {
        presetId: null,
        presetTitle: '',
        workMinutes: 0,
        shortBreakMinutes: 0,
        longBreakMinutes: 0,
        totalCycles: 0,
        
        currentPhase: 'work',
        currentCycle: 1,
        timeRemaining: 0,
        totalSeconds: 0,
        
        isRunning: false,
        isPaused: false,
        intervalId: null,
        
        sessionId: null,
        cyclesCompleted: 0,
        totalFocusMinutes: 0,
        totalBreakMinutes: 0,
    };

    // Save state to localStorage
    function saveTimerState() {
        localStorage.setItem('pomodoroState', JSON.stringify({
            presetId: timerState.presetId,
            presetTitle: timerState.presetTitle,
            workMinutes: timerState.workMinutes,
            shortBreakMinutes: timerState.shortBreakMinutes,
            longBreakMinutes: timerState.longBreakMinutes,
            totalCycles: timerState.totalCycles,
            currentPhase: timerState.currentPhase,
            currentCycle: timerState.currentCycle,
            timeRemaining: timerState.timeRemaining,
            totalSeconds: timerState.totalSeconds,
            isRunning: timerState.isRunning,
            isPaused: timerState.isPaused,
            sessionId: timerState.sessionId,
            cyclesCompleted: timerState.cyclesCompleted,
            totalFocusMinutes: timerState.totalFocusMinutes,
            totalBreakMinutes: timerState.totalBreakMinutes,
            savedAt: Date.now()
        }));
    }

    // Load state from localStorage
    function loadTimerState() {
        const saved = localStorage.getItem('pomodoroState');
        if (!saved) return false;
        
        const state = JSON.parse(saved);
        
        // Don't restore if saved more than 24 hours ago
        if (Date.now() - state.savedAt > 24 * 60 * 60 * 1000) {
            localStorage.removeItem('pomodoroState');
            return false;
        }
        
        // Restore timer state
        Object.assign(timerState, {
            presetId: state.presetId,
            presetTitle: state.presetTitle,
            workMinutes: state.workMinutes,
            shortBreakMinutes: state.shortBreakMinutes,
            longBreakMinutes: state.longBreakMinutes,
            totalCycles: state.totalCycles,
            currentPhase: state.currentPhase,
            currentCycle: state.currentCycle,
            timeRemaining: state.timeRemaining,
            totalSeconds: state.totalSeconds,
            sessionId: state.sessionId,
            cyclesCompleted: state.cyclesCompleted,
            totalFocusMinutes: state.totalFocusMinutes,
            totalBreakMinutes: state.totalBreakMinutes,
            isPaused: state.isPaused
        });
        
        // Update UI
        const infoBox = document.getElementById('selected-preset-info');
        infoBox.classList.add('active');
        document.getElementById('selected-preset-title').textContent = state.presetTitle;
        document.getElementById('selected-preset-details').textContent = 
            `${state.workMinutes}min work • ${state.shortBreakMinutes}min short break • ${state.longBreakMinutes}min long break`;
        
        updateTimerDisplay();
        updatePhaseDisplay();
        updateProgress();
        updateStats();
        
        document.getElementById('start-btn').disabled = false;
        document.getElementById('reset-btn').disabled = false;
        
        // Highlight selected preset card
        const presetCard = document.getElementById(`preset-card-${state.presetId}`);
        if (presetCard) {
            presetCard.classList.add('selected');
        }
        
        // If was paused, show resume button
        if (state.isPaused && state.sessionId) {
            document.getElementById('start-btn').style.display = 'none';
            document.getElementById('pause-btn').style.display = 'none';
            document.getElementById('resume-btn').style.display = 'inline-block';
            document.getElementById('resume-btn').disabled = false;
            document.getElementById('session-stats').style.display = 'grid';
        }
        
        return true;
    }

    // Clear saved state
    function clearTimerState() {
        localStorage.removeItem('pomodoroState');
    }

    // Tab switching
    function switchTab(tab) {
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(`tab-${tab}`).classList.add('active');

        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById(`${tab}-presets`).style.display = 'block';
    }

    // Load planner tasks
    function loadPlannerTasks(plannerId) {
        const taskList = document.getElementById('task-list');
        
        if (!plannerId) {
            taskList.innerHTML = `
                <div class="empty-tasks">
                    <i class="bi bi-journal-text"></i>
                    <p>Select a planner to see tasks</p>
                </div>
            `;
            return;
        }

        const planner = plannersData.find(p => p.id == plannerId);
        
        if (!planner || !planner.tasks || planner.tasks.length === 0) {
            taskList.innerHTML = `
                <div class="empty-tasks">
                    <i class="bi bi-clipboard-x"></i>
                    <p>No tasks in this planner</p>
                </div>
            `;
            return;
        }

        // Render tasks
        let tasksHtml = '<div class="task-list">';
        planner.tasks.forEach(task => {
            tasksHtml += `
                <div class="task-item ${task.taskStatus ? 'completed' : ''}">
                    <input type="checkbox" 
                        id="task-${task.id}" 
                        ${task.taskStatus ? 'checked' : ''}
                        onchange="toggleTask(${task.id})">
                    <label for="task-${task.id}">${task.taskName}</label>
                </div>
            `;
        });
        tasksHtml += '</div>';
        
        taskList.innerHTML = tasksHtml;
    }

    // Toggle task status
    async function toggleTask(taskId) {
        try {
            const response = await fetch(`/tasks/${taskId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                const taskItem = document.querySelector(`#task-${taskId}`).closest('.task-item');
                taskItem.classList.toggle('completed');
            }
        } catch (error) {
            console.error('Failed to toggle task:', error);
        }
    }

    // Helper function to select preset from card element
    function selectPresetFromCard(cardElement) {
        const id = cardElement.dataset.presetId;
        const title = cardElement.dataset.title;
        const work = parseInt(cardElement.dataset.work);
        const shortBreak = parseInt(cardElement.dataset.shortBreak);
        const longBreak = parseInt(cardElement.dataset.longBreak);
        const cycles = parseInt(cardElement.dataset.cycles);
        
        selectPreset(id, title, work, shortBreak, longBreak, cycles, cardElement);
    }

    // Select preset
    function selectPreset(id, title, work, shortBreak, longBreak, cycles, element) {
        timerState.presetId = id;
        timerState.presetTitle = title;
        timerState.workMinutes = work;
        timerState.shortBreakMinutes = shortBreak;
        timerState.longBreakMinutes = longBreak;
        timerState.totalCycles = cycles;
        
        timerState.currentPhase = 'work';
        timerState.currentCycle = 1;
        timerState.timeRemaining = work * 60;
        timerState.totalSeconds = work * 60;
        
        const infoBox = document.getElementById('selected-preset-info');
        infoBox.classList.add('active');
        document.getElementById('selected-preset-title').textContent = title;
        document.getElementById('selected-preset-details').textContent = 
            `${work}min work • ${shortBreak}min short break • ${longBreak}min long break`;
        
        updateTimerDisplay();
        updatePhaseDisplay();
        
        document.getElementById('start-btn').disabled = false;
        document.getElementById('reset-btn').disabled = false;
        
        document.querySelectorAll('.preset-card').forEach(card => {
            card.classList.remove('selected');
        });
        if (element) {
            element.classList.add('selected');
        }
        
        saveTimerState();
    }

    function clearSelection() {
        resetTimer();
        document.getElementById('selected-preset-info').classList.remove('active');
        document.getElementById('start-btn').disabled = true;
        document.getElementById('reset-btn').disabled = true;
        
        document.querySelectorAll('.preset-card').forEach(card => {
            card.classList.remove('selected');
        });
    }

    // Timer functions
    function startTimer() {
        if (!timerState.presetId) return;
        
        if (!timerState.sessionId) {
            startSession();
        }
        
        timerState.isRunning = true;
        timerState.isPaused = false;
        
        // Hide all control buttons first
        document.getElementById('start-btn').style.display = 'none';
        document.getElementById('pause-btn').style.display = 'inline-block';
        document.getElementById('resume-btn').style.display = 'none';
        document.getElementById('pause-btn').disabled = false;
        document.getElementById('session-stats').style.display = 'grid';
        
        timerState.intervalId = setInterval(() => {
            if (timerState.timeRemaining > 0) {
                timerState.timeRemaining--;
                updateTimerDisplay();
                updateProgress();
                saveTimerState();
            } else {
                handlePhaseComplete();
            }
        }, 1000);
    }

    function pauseTimer() {
        timerState.isRunning = false;
        timerState.isPaused = true;
        clearInterval(timerState.intervalId);
        
        // Show only resume and reset buttons
        document.getElementById('start-btn').style.display = 'none';
        document.getElementById('pause-btn').style.display = 'none';
        document.getElementById('resume-btn').style.display = 'inline-block';
        document.getElementById('resume-btn').disabled = false;
        
        saveTimerState();
    }

    function resumeTimer() {
        timerState.isPaused = false;
        timerState.isRunning = true;
        
        // Show only pause and reset buttons
        document.getElementById('start-btn').style.display = 'none';
        document.getElementById('pause-btn').style.display = 'inline-block';
        document.getElementById('resume-btn').style.display = 'none';
        document.getElementById('pause-btn').disabled = false;
        
        timerState.intervalId = setInterval(() => {
            if (timerState.timeRemaining > 0) {
                timerState.timeRemaining--;
                updateTimerDisplay();
                updateProgress();
                saveTimerState();
            } else {
                handlePhaseComplete();
            }
        }, 1000);
    }

    function resetTimer() {
        clearInterval(timerState.intervalId);
        
        if (timerState.sessionId) {
            completeSession();
        }
        
        timerState.isRunning = false;
        timerState.isPaused = false;
        timerState.currentPhase = 'work';
        timerState.currentCycle = 1;
        timerState.sessionId = null;
        timerState.cyclesCompleted = 0;
        timerState.totalFocusMinutes = 0;
        timerState.totalBreakMinutes = 0;
        
        if (timerState.presetId) {
            timerState.timeRemaining = timerState.workMinutes * 60;
            timerState.totalSeconds = timerState.workMinutes * 60;
        }
        
        updateTimerDisplay();
        updatePhaseDisplay();
        updateProgress();
        updateStats();
        
        document.getElementById('start-btn').style.display = 'inline-block';
        document.getElementById('start-btn').disabled = !timerState.presetId;
        document.getElementById('pause-btn').style.display = 'none';
        document.getElementById('resume-btn').style.display = 'none';
        document.getElementById('session-stats').style.display = 'none';
        
        clearTimerState();
    }

    function handlePhaseComplete() {
        clearInterval(timerState.intervalId);
    
        // Track completed work/break
        if (timerState.currentPhase === 'work') {
            timerState.totalFocusMinutes += timerState.workMinutes;
            timerState.cyclesCompleted++;
        } else {
            const breakMinutes = timerState.currentPhase === 'short_break' 
                ? timerState.shortBreakMinutes 
                : timerState.longBreakMinutes;
            timerState.totalBreakMinutes += breakMinutes;
        }
        
        updateStats();
        
        // Determine next phase
        if (timerState.currentPhase === 'work') {
            if (timerState.currentCycle >= timerState.totalCycles) {
                timerState.currentPhase = 'long_break';
                timerState.timeRemaining = timerState.longBreakMinutes * 60;
                timerState.totalSeconds = timerState.longBreakMinutes * 60;
            } else {
                timerState.currentPhase = 'short_break';
                timerState.timeRemaining = timerState.shortBreakMinutes * 60;
                timerState.totalSeconds = timerState.shortBreakMinutes * 60;
            }
        } else {
            if (timerState.currentPhase === 'long_break') {
                // Session complete!
                completeSession();
                
                // Show beautiful completion modal
                Swal.fire({
                    title: '🎉 Session Complete!',
                    html: `
                        <p style="font-size: 1.1rem; margin-bottom: 20px; color: #6b7280;">
                            Great work! You completed <strong style="color: #8c52ff;">${timerState.cyclesCompleted}</strong> focus cycles.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px;">
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                                <div style="font-size: 2.5rem; font-weight: 700; color: #9333ea;">${timerState.cyclesCompleted}</div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">Cycles</div>
                            </div>
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                                <div style="font-size: 2.5rem; font-weight: 700; color: #10b981;">${timerState.totalFocusMinutes}</div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">Focus Min</div>
                            </div>
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                                <div style="font-size: 2.5rem; font-weight: 700; color: #3b82f6;">${timerState.totalBreakMinutes}</div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">Break Min</div>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    iconColor: '#8c52ff',
                    confirmButtonText: 'Awesome! 🚀',
                    confirmButtonColor: '#8c52ff',
                    width: '600px',
                    padding: '3em',
                    backdrop: `
                        rgba(140, 82, 255, 0.1)
                        left top
                        no-repeat
                    `,
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'rounded-4',
                        confirmButton: 'rounded-pill px-5 py-2'
                    }
                });
                
                resetTimer();
                return;
            } else {
                timerState.currentCycle++;
                timerState.currentPhase = 'work';
                timerState.timeRemaining = timerState.workMinutes * 60;
                timerState.totalSeconds = timerState.workMinutes * 60;
            }
        }
        
        updatePhaseDisplay();
        updateProgress();
        saveTimerState();
        
        // Auto-continue to next phase
        startTimer();
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timerState.timeRemaining / 60);
        const seconds = timerState.timeRemaining % 60;
        document.getElementById('timer-display').textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    function updatePhaseDisplay() {
        let phaseText = '';
        let color = '';
        
        if (timerState.currentPhase === 'work') {
            phaseText = `Work Session`;
            color = '#9333ea';
        } else if (timerState.currentPhase === 'short_break') {
            phaseText = 'Short Break';
            color = '#3b82f6';
        } else if (timerState.currentPhase === 'long_break') {
            phaseText = 'Long Break';
            color = '#10b981';
        }
        
        document.getElementById('phase-display').textContent = phaseText;
        document.getElementById('cycle-display').textContent = `Cycle ${timerState.currentCycle} of ${timerState.totalCycles}`;
        document.getElementById('cycle-display').style.display = 'block';
        document.getElementById('progress-circle').style.stroke = color;
    }

    function updateProgress() {
        const circumference = 2 * Math.PI * 120;
        const progress = timerState.timeRemaining / timerState.totalSeconds;
        const offset = circumference * (1 - progress);
        
        document.getElementById('progress-circle').style.strokeDashoffset = offset;
    }

    function updateStats() {
        document.getElementById('cycles-completed').textContent = timerState.cyclesCompleted;
        document.getElementById('focus-minutes').textContent = timerState.totalFocusMinutes;
        document.getElementById('break-minutes').textContent = timerState.totalBreakMinutes;
    }

    // API calls
    async function startSession() {
        try {
            const response = await fetch('{{ route("pomodoro.sessions.start") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    preset_id: timerState.presetId,
                    planner_id: document.getElementById('planner-selector').value || null
                })
            });
            
            const data = await response.json();
            timerState.sessionId = data.session_id;
            saveTimerState();
        } catch (error) {
            console.error('Failed to start session:', error);
        }
    }

    async function completeSession() {
        if (!timerState.sessionId) return;
        
        try {
            await fetch('{{ route("pomodoro.sessions.complete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: timerState.sessionId,
                    cycles_completed: timerState.cyclesCompleted,
                    total_focus_minutes: timerState.totalFocusMinutes,
                    total_break_minutes: timerState.totalBreakMinutes
                })
            });
        } catch (error) {
            console.error('Failed to complete session:', error);
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        updateProgress();
        loadTimerState();
    });
</script>

@endsection
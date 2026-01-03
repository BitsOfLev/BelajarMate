// Pomodoro Timer JavaScript

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
    
    document.getElementById('start-btn').style.display = 'none';
    document.getElementById('pause-btn').style.display = 'inline-block';
    document.getElementById('pause-btn').disabled = false;
    document.getElementById('session-stats').style.display = 'grid';
    
    timerState.intervalId = setInterval(() => {
        if (timerState.timeRemaining > 0) {
            timerState.timeRemaining--;
            updateTimerDisplay();
            updateProgress();
        } else {
            handlePhaseComplete();
        }
    }, 1000);

    saveTimerState();
}

function pauseTimer() {
    timerState.isPaused = true;
    clearInterval(timerState.intervalId);
    
    document.getElementById('pause-btn').style.display = 'none';
    document.getElementById('resume-btn').style.display = 'inline-block';
    document.getElementById('resume-btn').disabled = false;

    saveTimerState();
}

function resumeTimer() {
    timerState.isPaused = false;
    startTimer();

    saveTimerState();
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
    if (timerState.currentPhase === 'work') {
        timerState.totalFocusMinutes += timerState.workMinutes;
        timerState.cyclesCompleted++;
    } else {
        timerState.totalBreakMinutes += (timerState.currentPhase === 'short_break' ? timerState.shortBreakMinutes : timerState.longBreakMinutes);
    }
    
    updateStats();
    
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
        if (timerState.currentPhase === 'long_break' || timerState.currentCycle >= timerState.totalCycles) {
            completeSession();
            alert('🎉 Pomodoro session complete! Great work!');
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
    pauseTimer();
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
        phaseText = `Work Session ${timerState.currentCycle}/${timerState.totalCycles}`;
        color = '#9333ea';
    } else if (timerState.currentPhase === 'short_break') {
        phaseText = 'Short Break';
        color = '#3b82f6';
    } else if (timerState.currentPhase === 'long_break') {
        phaseText = 'Long Break';
        color = '#10b981';
    }
    
    document.getElementById('phase-display').textContent = phaseText;
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

// API calls - These need the CSRF token and route URLs passed from Blade
async function startSession() {
    try {
        const response = await fetch(window.pomodoroRoutes.startSession, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({
                preset_id: timerState.presetId,
                planner_id: document.getElementById('planner-selector')?.value || null
            })
        });
        
        const data = await response.json();
        timerState.sessionId = data.session_id;
    } catch (error) {
        console.error('Failed to start session:', error);
    }
}

async function completeSession() {
    if (!timerState.sessionId) return;
    
    try {
        await fetch(window.pomodoroRoutes.completeSession, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
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
    loadTimerState(); // ADD THIS - restore state on page load
    
    // Auto-save every 5 seconds when timer is running
    setInterval(() => {
        if (timerState.isRunning || timerState.isPaused) {
            saveTimerState();
        }
    }, 5000);
});
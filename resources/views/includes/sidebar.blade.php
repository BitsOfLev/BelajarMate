<!-- Sidebar -->
    <nav class="sidebar close">

        <!-- Toggle -->
        <div class="sidebar__toggle-item" title="Expand">
            <i class='bx bx-sidebar sidebar__toggle'></i>
        </div>

        <!-- Menu -->
        <div class="sidebar__menu">
            <li class="sidebar__menu-item">
                <a href="/home" class="sidebar__menu-link" title="Home">
                    <i class='bx bx-home-alt sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Home</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/study-partner" class="sidebar__menu-link" title="Study Partner Management">
                    <i class='bx bx-group sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Study Partner</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/study-planner" class="sidebar__menu-link" title="Study Planner Management">
                    <i class='bx bx-calendar sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Study Planner</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/study-session" class="sidebar__menu-link" title="Study Session Management">
                    <i class='bx bx-time-five sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Study Session</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="{{ route('notes.index') }}" class="sidebar__menu-link {{ Request::is('notes*') ? 'active' : '' }}" title="Notes">
                    <i class='bx bx-notepad sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Notes</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/pomodoro" class="sidebar__menu-link" title="Pomodoro">
                    <i class='bx bx-timer sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Pomodoro</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/blog" class="sidebar__menu-link" title="Blog">
                    <i class='bx bxs-news sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Blog</span>
                </a>
            </li>
        </div>

        <!-- Footer -->
       <div class="sidebar__footer">
            <li class="sidebar__menu-item">
                <a href="{{ route('logout') }}" class="sidebar__menu-link"
                onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">
                    <i class='bx bx-log-out sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Logout</span>
                </a>
            </li>

            <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <li class="sidebar__menu-item">
                <a href="#" class="sidebar__menu-link">
                    <i class='bx bx-cog sidebar__menu-icon'></i>
                    <span class="sidebar__menu-text">Settings</span>
                </a>
            </li>
            <li class="sidebar__mode">
                <div class="sidebar__mode-icons">
                    <i class='bx bx-moon'></i>
                </div>
                <span class="sidebar__menu-text">Dark Mode</span>
                <div class="sidebar__toggle-switch">
                <span class="switch"></span>
                </div>
            </li>
        </div>
    </nav>
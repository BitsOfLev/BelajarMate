// Sidebar activity
const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".sidebar__toggle-item"),
      modeSwitch = body.querySelector(".sidebar__mode"),
      modeText = body.querySelector(".sidebar__mode-text");

// Close sidebar by default on mobile
function handleInitialSidebarState() {
    if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
    }
}
handleInitialSidebarState(); // Run once when page loads

// Sidebar toggle button
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

// Dark mode toggle
modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");
});

// Optional: Adjust layout only if needed on resize
window.addEventListener("resize", () => {
    // Only handle auto-close when entering mobile size
    if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
    }
});

//top bar responsive
const search = document.querySelector('.topbar__search');
const searchIcon = search.querySelector('i');

searchIcon.addEventListener('click', () => {
    search.classList.toggle('active');
});

//profile dropdown
document.addEventListener("DOMContentLoaded", () => {
    const profile = document.querySelector(".topbar__profile-dropdown");

    profile.addEventListener("click", () => {
        profile.classList.toggle("active");
    });

    // Optional: Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!profile.contains(e.target)) {
            profile.classList.remove("active");
        }
    });
});


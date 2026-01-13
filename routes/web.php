<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\StudyPartnerController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SocialProfileController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\StudyPlannerController;
use App\Http\Controllers\StudyTaskController;
use App\Http\Controllers\Admin\Auth\LoginController; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminSession;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\DataManagementController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\EducationLevelController;
use App\Http\Controllers\Admin\MbtiController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\SessionInviteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\BlogLikeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PomodoroPresetController;
use App\Http\Controllers\PomodoroSessionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteResourceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\BlogModerationController;
use App\Http\Controllers\Admin\AdminDashboardController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home / welcome
Route::get('/', fn() => view('welcome'));

// -------------------------------
// Admin Landing & Login (Public)
// -------------------------------
Route::get('/admin', fn() => view('admin.landing'))->name('admin.landing');
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->middleware('admin.session');

// Admin logout (no middleware needed now)
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// -------------------------------
// Admin Routes (Authenticated)
// -------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users CRUD
    Route::resource('users', UserController::class);

    // Data Management Dashboard
    Route::get('/data-management', [DataManagementController::class, 'index'])->name('data.index');

    // -------------------------------
    // Data Management: Universities
    // -------------------------------
    Route::prefix('data-management/university')
        ->name('data-management.university.')
        ->group(function () {
            Route::get('/', [UniversityController::class, 'index'])->name('index');
            Route::get('/create', [UniversityController::class, 'create'])->name('create');
            Route::post('/', [UniversityController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UniversityController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UniversityController::class, 'update'])->name('update');
            Route::delete('/{id}', [UniversityController::class, 'destroy'])->name('destroy');

            // Approval actions
            Route::put('/{id}/approve', [UniversityController::class, 'approve'])->name('approve');
            Route::put('/{id}/reject', [UniversityController::class, 'reject'])->name('reject');
        });

    // -------------------------------
    // Data Management: Courses
    // -------------------------------
    Route::prefix('data-management/course')
        ->name('data-management.course.')
        ->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('index');
            Route::get('/create', [CourseController::class, 'create'])->name('create');
            Route::post('/', [CourseController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CourseController::class, 'update'])->name('update');
            Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');

            // Approval actions
            Route::put('/{id}/approve', [CourseController::class, 'approve'])->name('approve');
            Route::put('/{id}/reject', [CourseController::class, 'reject'])->name('reject');

            // Categories CRUD
            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', [CourseCategoryController::class, 'index'])->name('index');
                Route::get('/create', [CourseCategoryController::class, 'create'])->name('create');
                Route::post('/', [CourseCategoryController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CourseCategoryController::class, 'edit'])->name('edit');
                Route::put('/{id}', [CourseCategoryController::class, 'update'])->name('update');
                Route::delete('/{id}', [CourseCategoryController::class, 'destroy'])->name('destroy');
            });
        });

    // -------------------------------
    // Data Management: Education Levels
    // -------------------------------
    Route::prefix('data-management/education-level')
        ->name('data-management.education-level.')
        ->group(function () {
            Route::get('/', [EducationLevelController::class, 'index'])->name('index');
            Route::get('/create', [EducationLevelController::class, 'create'])->name('create');
            Route::post('/', [EducationLevelController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EducationLevelController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EducationLevelController::class, 'update'])->name('update');
            Route::delete('/{id}', [EducationLevelController::class, 'destroy'])->name('destroy');
        });

    // -------------------------------
    // Data Management: MBTI Types
    // -------------------------------
    Route::prefix('data-management/mbti')
        ->name('data-management.mbti.')
        ->group(function () {
            Route::get('/', [MbtiController::class, 'index'])->name('index');
            Route::get('/create', [MbtiController::class, 'create'])->name('create');
            Route::post('/', [MbtiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [MbtiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MbtiController::class, 'update'])->name('update');
            Route::delete('/{id}', [MbtiController::class, 'destroy'])->name('destroy');
        });

    // -------------------------------
    // Blog Management
    // -------------------------------
    Route::prefix('blog-moderation')->name('blog-moderation.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BlogModerationController::class, 'index'])->name('index');
        
        // Pending Blogs
        Route::get('/pending-blogs', [App\Http\Controllers\Admin\BlogModerationController::class, 'pendingBlogs'])->name('pending-blogs');
        Route::get('/blogs/{blog}', [App\Http\Controllers\Admin\BlogModerationController::class, 'showBlog'])->name('show-blog');
        Route::post('/blogs/{blog}/approve', [App\Http\Controllers\Admin\BlogModerationController::class, 'approveBlog'])->name('approve-blog');
        Route::post('/blogs/{blog}/reject', [App\Http\Controllers\Admin\BlogModerationController::class, 'rejectBlog'])->name('reject-blog');
        Route::delete('/blogs/{blog}', [App\Http\Controllers\Admin\BlogModerationController::class, 'deleteBlog'])->name('delete-blog');
        
        // Pending Comments
        Route::get('/pending-comments', [App\Http\Controllers\Admin\BlogModerationController::class, 'pendingComments'])->name('pending-comments');
        Route::get('/comments/{comment}', [App\Http\Controllers\Admin\BlogModerationController::class, 'showComment'])->name('show-comment');
        Route::post('/comments/{comment}/approve', [App\Http\Controllers\Admin\BlogModerationController::class, 'approveComment'])->name('approve-comment');
        Route::post('/comments/{comment}/reject', [App\Http\Controllers\Admin\BlogModerationController::class, 'rejectComment'])->name('reject-comment');
        Route::delete('/comments/{comment}', [App\Http\Controllers\Admin\BlogModerationController::class, 'deleteComment'])->name('delete-comment');
        
        // Reports
        Route::get('/reports', [App\Http\Controllers\Admin\BlogModerationController::class, 'reports'])->name('reports');
        Route::get('/reports/{report}', [App\Http\Controllers\Admin\BlogModerationController::class, 'showReport'])->name('show-report');
        Route::post('/reports/{report}/dismiss', [App\Http\Controllers\Admin\BlogModerationController::class, 'dismissReport'])->name('dismiss-report');
        Route::post('/reports/{report}/action', [App\Http\Controllers\Admin\BlogModerationController::class, 'actionReport'])->name('action-report');
        Route::post('/reports/{report}/investigate', [App\Http\Controllers\Admin\BlogModerationController::class, 'investigateReport'])->name('investigate-report');
        Route::post('/reports/{report}/revert', [BlogModerationController::class, 'revertReport'])->name('revert-report');
    });
 
});


// -------------------------------
// Authenticated User Routes
// -------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // User pages
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::view('/pomodoro', 'pomodoro')->name('pomodoro'); //

    // User logout
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // -------------------------------
    // Profile Routes
    // -------------------------------
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'view'])->name('profile.view');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/edit', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/info/edit', [UserInfoController::class, 'edit'])->name('profile.info.edit');
        Route::patch('/info/update', [UserInfoController::class, 'update'])->name('profile.info.update');
        Route::post('/schedule/upload', [UserInfoController::class, 'uploadSchedule'])->name('profile.schedule.upload');
        Route::delete('/schedule/delete', [UserInfoController::class, 'deleteSchedule'])->name('profile.schedule.delete');

        Route::get('/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics');
    });

    // -------------------------------
    // Study Partner & Connections
    // -------------------------------
    Route::get('/study-partner', [StudyPartnerController::class, 'index'])->name('study-partner.index');
    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendation.index');
    Route::get('/study-partner/profile/{user}', [SocialProfileController::class, 'show'])
        ->name('study-partner.social-profile.show');

    Route::prefix('connections')->group(function () {
        Route::get('/', [ConnectionController::class, 'index'])->name('connections.index');
        Route::post('/send', [ConnectionController::class, 'sendRequest'])->name('connections.send');
        Route::post('/accept/{id}', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
        Route::post('/reject/{id}', [ConnectionController::class, 'rejectRequest'])->name('connections.reject');
        Route::post('/block/{id}', [ConnectionController::class, 'block'])->name('connections.block');
        Route::post('/remove/{id}', [ConnectionController::class, 'remove'])->name('connections.remove');
    });

    // -------------------------------
    // Study Planner & Tasks
    // -------------------------------
    Route::resource('study-planner', StudyPlannerController::class);

    Route::post('/study-planner/{planner}/tasks', [StudyTaskController::class, 'store'])->name('study-task.store');

    Route::prefix('tasks')->group(function () {
        Route::put('/{task}', [StudyTaskController::class, 'update'])->name('study-task.update');
        Route::delete('/{task}', [StudyTaskController::class, 'destroy'])->name('study-task.destroy');
        Route::patch('/{task}/toggle', [StudyTaskController::class, 'toggle'])->name('study-task.toggle');
    });

    // -------------------------------
    // Study Session Management
    // -------------------------------
    Route::prefix('study-session')->name('study-session.')->group(function () {
        // Main CRUD routes
        Route::get('/', [StudySessionController::class, 'index'])->name('index');
        Route::get('/create', [StudySessionController::class, 'create'])->name('create');
        Route::post('/', [StudySessionController::class, 'store'])->name('store');
        Route::get('/{session}', [StudySessionController::class, 'show'])->name('show');
        Route::get('/{session}/edit', [StudySessionController::class, 'edit'])->name('edit');
        Route::put('/{session}', [StudySessionController::class, 'update'])->name('update');
        Route::delete('/{session}', [StudySessionController::class, 'destroy'])->name('destroy');

        // Session invite management (for adding more invites to existing session)
        Route::post('/{session}/invite', [StudySessionController::class, 'invite'])->name('invite');
        
        // View all invites for a session
        Route::get('/{session}/invites', [StudySessionController::class, 'invites'])->name('invites');
    });

    // -------------------------------
    // Session Invites Management
    // -------------------------------
    Route::prefix('invites')->name('invites.')->group(function () {
        // Respond to an invite (accept/decline)
        Route::post('/{invite}/respond', [SessionInviteController::class, 'respond'])->name('respond');
        
        // Cancel an invite (by session owner)
        Route::delete('/{invite}/cancel', [SessionInviteController::class, 'cancel'])->name('cancel');
    });

    // -------------------------------
    // Blog Management
    // -------------------------------
    Route::prefix('blog')->name('blog.')->middleware(['auth', 'verified'])->group(function () {

        // Main feed (DEFAULT - what users see first)
        Route::get('/', [BlogController::class, 'feed'])->name('feed');
        
        // My blogs
        Route::get('/my-blogs', [BlogController::class, 'index'])->name('index');
        
        // Liked blogs
        Route::get('/liked', [BlogController::class, 'liked'])->name('liked');
        
        // Create blog
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        
        // View blog
        Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
        
        // Edit blog
        Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
        
        // Delete blog
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');

        // Like/Unlike blog
        Route::post('/{blog}/like', [BlogLikeController::class, 'toggle'])->name('like');

        // Comments
        Route::prefix('{blog}/comments')->name('comments.')->group(function () {
            Route::post('/', [CommentsController::class, 'store'])->name('store');
            Route::put('/{comment}', [CommentsController::class, 'update'])->name('update');
            Route::delete('/{comment}', [CommentsController::class, 'destroy'])->name('destroy');
        });
    });

    // -------------------------------
    // Reports (blogs or comments)
    // -------------------------------
    Route::prefix('reports')->name('reports.')->middleware(['auth', 'verified'])->group(function () {
        
        // Users submit report
        Route::post('/', [ReportController::class, 'store'])->name('store');

        // Admin only routes (you'll build admin panel later)
        Route::middleware('admin')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/{report}', [ReportController::class, 'show'])->name('show');
            Route::put('/{report}', [ReportController::class, 'update'])->name('update');
            Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
        });
    });

    // -------------------------------
    // Pomodoro
    // -------------------------------
    Route::prefix('pomodoro')->name('pomodoro.')->middleware(['auth', 'verified'])->group(function () {
        // Main Hub / Index
        Route::get('/', [PomodoroPresetController::class, 'index'])->name('index');
  
        // Presets CRUD
        Route::get('/presets/create', [PomodoroPresetController::class, 'create'])->name('presets.create');
        Route::post('/presets', [PomodoroPresetController::class, 'store'])->name('presets.store');
        Route::get('/presets/{preset}/edit', [PomodoroPresetController::class, 'edit'])->name('presets.edit');
        Route::put('/presets/{preset}', [PomodoroPresetController::class, 'update'])->name('presets.update');
        Route::delete('/presets/{preset}', [PomodoroPresetController::class, 'destroy'])->name('presets.destroy');
        
        // Session Actions
        Route::post('/sessions/start', [PomodoroSessionController::class, 'start'])->name('sessions.start');
        Route::post('/sessions/complete', [PomodoroSessionController::class, 'complete'])->name('sessions.complete');

        // History
        Route::get('/history', [PomodoroSessionController::class, 'history'])->name('history');
    });

    // -------------------------------
    // Notes Management
    // -------------------------------
    Route::prefix('notes')->name('notes.')->middleware(['auth', 'verified'])->group(function () {
        // Main Notes CRUD
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::get('/create', [NoteController::class, 'create'])->name('create');
        Route::post('/', [NoteController::class, 'store'])->name('store');
        Route::get('/{note}', [NoteController::class, 'show'])->name('show');
        Route::get('/{note}/edit', [NoteController::class, 'edit'])->name('edit');
        Route::put('/{note}', [NoteController::class, 'update'])->name('update');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('destroy');

        // Note Resources (file uploads and links)
        Route::prefix('{note}/resources')->name('resources.')->group(function () {
            Route::post('/', [NoteResourceController::class, 'store'])->name('store');
        });
        
        // Resource actions (not nested under note)
        Route::prefix('resources')->name('resources.')->group(function () {
            Route::get('/{resource}/view', [NoteResourceController::class, 'view'])->name('view'); // ADD THIS
            Route::get('/{resource}/download', [NoteResourceController::class, 'download'])->name('download');
            Route::delete('/{resource}', [NoteResourceController::class, 'destroy'])->name('destroy');
        });
    });

    // -------------------------------
    // Messaging
    // -------------------------------
    Route::prefix('messages')->name('messages.')->middleware(['auth', 'verified'])->group(function () {
        // Main inbox page
        Route::get('/', [MessageController::class, 'index'])->name('index');
        
        // Start new conversation with a user
        Route::post('/start/{user}', [MessageController::class, 'startConversation'])->name('start');
        
        // Conversation actions
        Route::prefix('conversation/{conversation}')->name('conversation.')->group(function () {
            Route::get('/', [MessageController::class, 'show'])->name('show');
            Route::post('/', [MessageController::class, 'store'])->name('store');
            Route::get('/check', [MessageController::class, 'checkNewMessages'])->name('check');
            Route::post('/mark-read', [MessageController::class, 'markAsRead'])->name('mark-read');
        });
    });

    // -------------------------------
    // Notifications
    // -------------------------------
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::get('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::get('/clear-read', [App\Http\Controllers\NotificationController::class, 'clearRead'])->name('clear-read');
    });
});

require __DIR__ . '/auth.php';


 


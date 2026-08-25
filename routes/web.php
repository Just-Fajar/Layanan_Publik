<?php

use App\Http\Controllers\CalendarEvent\Admin\DashboardController as CalendarAdminDashboard;
use App\Http\Controllers\CalendarEvent\Admin\EventController as CalendarAdminEvent;
use App\Http\Controllers\CalendarEvent\Admin\RegistrationManagementController as CalendarAdminRegistration;
use App\Http\Controllers\CalendarEvent\Admin\UserManagementController as CalendarAdminUser;
use App\Http\Controllers\CalendarEvent\Auth\LoginController as CalendarUserLogin;
use App\Http\Controllers\CalendarEvent\Auth\RegisterController as CalendarUserRegister;
use App\Http\Controllers\CalendarEvent\EventController as CalendarEventController;
use App\Http\Controllers\CalendarEvent\User\DashboardController as CalendarUserDashboard;
use App\Http\Controllers\CalendarEvent\User\EventRegistrationController as CalendarUserEventRegistration;
use App\Http\Controllers\CalendarEvent\User\ProfileController as CalendarUserProfile;
use App\Http\Controllers\Esport\Admin\DashboardController as EsportAdminDashboard;
use App\Http\Controllers\Esport\Admin\NewsController as EsportAdminNews;
use App\Http\Controllers\Esport\Admin\RegistrationManagementController as EsportAdminRegistration;
use App\Http\Controllers\Esport\Admin\TournamentController as EsportAdminTournament;
use App\Http\Controllers\Esport\Admin\UserManagementController as EsportAdminUser;
use App\Http\Controllers\Esport\Auth\LoginController as EsportUserLogin;
use App\Http\Controllers\Esport\Auth\RegisterController as EsportUserRegister;
use App\Http\Controllers\Esport\NewsController as EsportNews;
use App\Http\Controllers\Esport\PageController as EsportPage;
use App\Http\Controllers\Esport\TournamentController as EsportTournament;
use App\Http\Controllers\Esport\User\DashboardController as EsportUserDashboard;
use App\Http\Controllers\Esport\User\ProfileController as EsportUserProfile;
use App\Http\Controllers\Esport\User\TournamentRegistrationController as EsportUserTournamentRegistration;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage route
Route::get('/', function () {
    return view('homepage.homepage');
})->name('homepage');

// Buku Tamu route
Route::get('/buku-tamu', function () {
    return view('buku_tamu.visitor');
})->name('buku-tamu');

// Admin routes (Buku Tamu & Auth)
Route::prefix('buku-tamu/admin')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin.role:module,buku_tamu'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/calendar', [AuthController::class, 'calendar'])->name('admin.calendar');
    });
});

/*
|--------------------------------------------------------------------------
| Public Esport
|--------------------------------------------------------------------------
*/
Route::prefix('esport')->name('esport.')->group(function () {
    Route::get('/', [EsportPage::class, 'home'])->name('home');
    Route::get('/about', [EsportPage::class, 'about'])->name('about');
    Route::get('/contact', [EsportPage::class, 'contact'])->name('contact');

    Route::get('/tournaments', [EsportTournament::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/{tournament}', [EsportTournament::class, 'show'])->name('tournaments.show');

    Route::get('/news', [EsportNews::class, 'index'])->name('news.index');
    Route::get('/news/{news}', [EsportNews::class, 'show'])->name('news.show');
});

/*
|--------------------------------------------------------------------------
| Esport User Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('esport')->name('esport.auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [EsportUserLogin::class, 'showLogin'])->name('login');
        Route::post('/login', [EsportUserLogin::class, 'login']);
        Route::get('/register', [EsportUserRegister::class, 'showRegister'])->name('register');
        Route::post('/register', [EsportUserRegister::class, 'register']);
    });
    Route::post('/logout', [EsportUserLogin::class, 'logout'])->name('logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Esport User Portal (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::prefix('esport/user')->name('esport.user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [EsportUserDashboard::class, 'index'])->name('dashboard');

    // Tournaments & Registrations
    Route::get('/tournaments', [EsportUserTournamentRegistration::class, 'index'])->name('tournaments.index');
    Route::post('/tournaments/{tournament}/register', [EsportUserTournamentRegistration::class, 'register'])->name('tournaments.register');
    Route::delete('/tournaments/{registration}/cancel', [EsportUserTournamentRegistration::class, 'cancel'])->name('tournaments.cancel');

    // Profile
    Route::get('/profile', [EsportUserProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [EsportUserProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [EsportUserProfile::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Admin Esport (RBAC Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('buku-tamu/admin/esport')
    ->name('esport.admin.')
    ->middleware(['admin.role:module,esport'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [EsportAdminDashboard::class, 'index'])->name('dashboard');

        // Tournaments CRUD
        Route::get('/tournaments', [EsportAdminTournament::class, 'index'])->name('tournaments.index');
        Route::get('/tournaments/create', [EsportAdminTournament::class, 'create'])->name('tournaments.create');
        Route::post('/tournaments', [EsportAdminTournament::class, 'store'])->name('tournaments.store');
        Route::get('/tournaments/{tournament}/edit', [EsportAdminTournament::class, 'edit'])->name('tournaments.edit');
        Route::put('/tournaments/{tournament}', [EsportAdminTournament::class, 'update'])->name('tournaments.update');
        Route::delete('/tournaments/{tournament}', [EsportAdminTournament::class, 'destroy'])->name('tournaments.destroy');

        // News CRUD
        Route::get('/news', [EsportAdminNews::class, 'index'])->name('news.index');
        Route::get('/news/create', [EsportAdminNews::class, 'create'])->name('news.create');
        Route::post('/news', [EsportAdminNews::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [EsportAdminNews::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [EsportAdminNews::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [EsportAdminNews::class, 'destroy'])->name('news.destroy');

        // Registrations Management
        Route::get('/registrations', [EsportAdminRegistration::class, 'index'])->name('registrations.index');
        Route::get('/registrations/{registration}', [EsportAdminRegistration::class, 'show'])->name('registrations.show');
        Route::post('/registrations/{registration}/approve', [EsportAdminRegistration::class, 'approve'])->name('registrations.approve');
        Route::post('/registrations/{registration}/reject', [EsportAdminRegistration::class, 'reject'])->name('registrations.reject');

        // User Management
        Route::get('/users', [EsportAdminUser::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [EsportAdminUser::class, 'show'])->name('users.show');
    });

/*
|--------------------------------------------------------------------------
| Calendar User Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('calendar')->name('calendar.auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [CalendarUserLogin::class, 'showLogin'])->name('login');
        Route::post('/login', [CalendarUserLogin::class, 'login']);
        Route::get('/register', [CalendarUserRegister::class, 'showRegister'])->name('register');
        Route::post('/register', [CalendarUserRegister::class, 'register']);
    });
    Route::post('/logout', [CalendarUserLogin::class, 'logout'])->name('logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Calendar User Portal (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::prefix('calendar/user')->name('calendar.user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CalendarUserDashboard::class, 'index'])->name('dashboard');

    // Events & Registrations
    Route::get('/events', [CalendarUserEventRegistration::class, 'index'])->name('events.index');
    Route::get('/events/{registration}', [CalendarUserEventRegistration::class, 'show'])->name('events.show');
    Route::post('/events/{event}/register', [CalendarUserEventRegistration::class, 'register'])->name('events.register');
    Route::delete('/events/{registration}/cancel', [CalendarUserEventRegistration::class, 'cancel'])->name('events.cancel');

    // Profile
    Route::get('/profile', [CalendarUserProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CalendarUserProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [CalendarUserProfile::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Public Calendar Event
|--------------------------------------------------------------------------
*/
Route::prefix('calendar')->name('calendar.')->group(function () {
    Route::get('/', [CalendarEventController::class, 'index'])->name('index');
    Route::get('/view/month', [CalendarEventController::class, 'calendar'])->name('view');
    Route::get('/{event}', [CalendarEventController::class, 'show'])->name('show');
});
Route::get('/calendar-view', [CalendarEventController::class, 'calendar'])->name('calendar.view.legacy');

/*
|--------------------------------------------------------------------------
| Admin Calendar Event (RBAC Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('buku-tamu/admin/calendar')
    ->name('calendar.admin.')
    ->middleware(['admin.role:module,calendar'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [CalendarAdminDashboard::class, 'index'])->name('dashboard');

        // Events CRUD
        Route::get('/events', [CalendarAdminEvent::class, 'index'])->name('events.index');
        Route::get('/events/create', [CalendarAdminEvent::class, 'create'])->name('events.create');
        Route::post('/events', [CalendarAdminEvent::class, 'store'])->name('events.store');
        Route::get('/events/{event}', [CalendarAdminEvent::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [CalendarAdminEvent::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [CalendarAdminEvent::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [CalendarAdminEvent::class, 'destroy'])->name('events.destroy');
        Route::post('/events/bulk', [CalendarAdminEvent::class, 'bulkAction'])->name('events.bulk');

        // Registrations Management
        Route::get('/registrations', [CalendarAdminRegistration::class, 'index'])->name('registrations.index');
        Route::get('/registrations/{registration}', [CalendarAdminRegistration::class, 'show'])->name('registrations.show');
        Route::post('/registrations/{registration}/attend', [CalendarAdminRegistration::class, 'attend'])->name('registrations.attend');
        Route::post('/registrations/{registration}/cancel', [CalendarAdminRegistration::class, 'cancel'])->name('registrations.cancel');

        // User Management
        Route::get('/users', [CalendarAdminUser::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [CalendarAdminUser::class, 'show'])->name('users.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

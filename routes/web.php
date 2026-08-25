<?php

use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\CalendarEvent\Admin\EventController as CalendarAdminEvent;
use App\Http\Controllers\CalendarEvent\EventController as CalendarEventController;
use App\Http\Controllers\Esport\Admin\NewsController as EsportAdminNews;
use App\Http\Controllers\Esport\Admin\TournamentController as EsportAdminTournament;
use App\Http\Controllers\Esport\NewsController as EsportNews;
use App\Http\Controllers\Esport\PageController as EsportPage;
use App\Http\Controllers\Esport\TournamentController as EsportTournament;
use App\Http\Controllers\QRCodeController;
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
        Route::get('/dashboard/qrcode', [QRCodeController::class, 'showQRPage'])->name('admin.qrcode');
        Route::get('/dashboard/qrcode/visitor', [QRCodeController::class, 'generateVisitorQR'])->name('qr.visitor');
        Route::get('/dashboard/qrcode/download', [QRCodeController::class, 'downloadQR'])->name('qr.download');
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
| Admin Esport (RBAC Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('buku-tamu/admin/esport')
    ->name('esport.admin.')
    ->middleware(['admin.role:module,esport'])
    ->group(function () {
        Route::get('/tournaments', [EsportAdminTournament::class, 'index'])->name('tournaments.index');
        Route::get('/tournaments/create', [EsportAdminTournament::class, 'create'])->name('tournaments.create');
        Route::post('/tournaments', [EsportAdminTournament::class, 'store'])->name('tournaments.store');
        Route::get('/tournaments/{tournament}/edit', [EsportAdminTournament::class, 'edit'])->name('tournaments.edit');
        Route::put('/tournaments/{tournament}', [EsportAdminTournament::class, 'update'])->name('tournaments.update');
        Route::delete('/tournaments/{tournament}', [EsportAdminTournament::class, 'destroy'])->name('tournaments.destroy');

        Route::get('/news', [EsportAdminNews::class, 'index'])->name('news.index');
        Route::get('/news/create', [EsportAdminNews::class, 'create'])->name('news.create');
        Route::post('/news', [EsportAdminNews::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [EsportAdminNews::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [EsportAdminNews::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [EsportAdminNews::class, 'destroy'])->name('news.destroy');
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
        Route::get('/events', [CalendarAdminEvent::class, 'index'])->name('events.index');
        Route::get('/events/create', [CalendarAdminEvent::class, 'create'])->name('events.create');
        Route::post('/events', [CalendarAdminEvent::class, 'store'])->name('events.store');
        Route::get('/events/{event}', [CalendarAdminEvent::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [CalendarAdminEvent::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [CalendarAdminEvent::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [CalendarAdminEvent::class, 'destroy'])->name('events.destroy');
        Route::post('/events/bulk', [CalendarAdminEvent::class, 'bulkAction'])->name('events.bulk');
    });

// Ekspresi Wajah route
Route::view('/ekspresi', 'ekspresi');
Route::post('/ekspresi', [VisitorController::class, 'store'])->name('ekspresi.store');

require __DIR__ . '/auth.php';

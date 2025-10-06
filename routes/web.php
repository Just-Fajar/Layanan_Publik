<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Esport\PageController as EsportPage;
use App\Http\Controllers\Esport\TournamentController as EsportTournament;
use App\Http\Controllers\Esport\NewsController as EsportNews;
use App\Http\Controllers\Esport\Admin\TournamentController as EsportAdminTournament;
use App\Http\Controllers\Esport\Admin\NewsController as EsportAdminNews;

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

// Admin routes
Route::prefix('buku-tamu/admin')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/calendar', [AuthController::class, 'calendar'])->name('admin.calendar');
    Route::get('/dashboard/qrcode', [QRCodeController::class, 'showQRPage'])->name('admin.qrcode');
});

// QR Code routes
Route::prefix('buku-tamu/admin')->group(function () {
    Route::get('/dashboard/qrcode', [QRCodeController::class, 'showQRPage'])->name('qr.admin');
    Route::get('/dashboard/qrcode/visitor', [QRCodeController::class, 'generateVisitorQR'])->name('qr.visitor');
    Route::get('/dashboard/qrcode/download', [QRCodeController::class, 'downloadQR'])->name('qr.download');
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
| Admin Esport (pakai admin yang sudah ada)
|--------------------------------------------------------------------------
*/
Route::prefix('buku-tamu/admin/esport')
    ->name('esport.admin.')
    ->middleware(['admin.auth']) // sesuaikan jika alias middleware-mu beda
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

    // Tambah 1 baris:
Route::view('/ekspresi', 'ekspresi');  // buka di http://localhost:8000/ekspresi
Route::post('/ekspresi', [VisitorController::class, 'store'])->name('ekspresi.store');


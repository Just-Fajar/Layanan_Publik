<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\ExpressionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua rute di sini otomatis diprefix "/api" dan pakai middleware "api".
*/

// ---------- Public ----------
Route::post('/visitors', [VisitorController::class, 'store']);

// ---------- Auth ----------
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

// ---------- Admin / Protected ----------
// (Saat ini hanya 'api'; jika ingin benar-benar aman, tambahkan 'auth:sanctum' atau guard lain)
Route::middleware(['api'])->group(function () {
    Route::get('/visitors', [VisitorController::class, 'index']);
    Route::get('/visitors/{id}', [VisitorController::class, 'show'])->whereNumber('id');
    Route::put('/visitors/{id}', [VisitorController::class, 'update'])->whereNumber('id');
    Route::delete('/visitors/{id}', [VisitorController::class, 'destroy'])->whereNumber('id');
    Route::get('/statistics', [VisitorController::class, 'statistics']);
    Route::get('/export/pdf', [VisitorController::class, 'exportPdf']);
});

// ---------- Ekspresi (face-api logging) ----------
Route::post('/expressions', [ExpressionController::class, 'store']);
Route::get('/expressions', [ExpressionController::class, 'index']);

// ---------- User via Sanctum ----------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// (Opsional) Health check untuk root "/api"
Route::get('/', fn () => response()->json(['ok' => true, 'service' => 'api']));

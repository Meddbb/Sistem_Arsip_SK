<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SKController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes - untuk tamu
Route::get('/', [SKController::class, 'index'])->name('home');
Route::get('/sks/{sk}/download', [SKController::class, 'download'])->name('sks.download');
Route::get('/sks/{sk}/preview', [SKController::class, 'preview'])->name('sks.preview');

// Authentication routes (dihandle oleh Breeze)
require __DIR__ . '/auth.php';

// Protected routes - hanya untuk user yang login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SK Management
    Route::resource('sks', SKController::class)->except(['index']);
    Route::get('/sks', [SKController::class, 'index'])->name('sks.index');

    // User Management - hanya untuk admin
    Route::middleware('can:viewAny,App\Models\User')->group(function () {
        Route::resource('users', UserController::class);
    });
});

<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dealers', DealerController::class)->except('show');
    Route::resource('departments', DepartmentController::class)->except('show');
    Route::resource('areas', AreaController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
});

Route::middleware(['auth', 'role:admin,supervisor'])->group(function () {
    Route::resource('tasks', TaskController::class)->except('show');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{submission}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::put('/reviews/{submission}', [ReviewController::class, 'update'])->name('reviews.update');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

Route::middleware(['auth', 'role:dealer'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {
        Route::get('/', [SubmissionController::class, 'index'])->name('index');
        Route::get('/tasks/{task}/create', [SubmissionController::class, 'create'])->name('create');
        Route::post('/tasks/{task}', [SubmissionController::class, 'store'])->name('store');
        Route::get('/{submission}/edit', [SubmissionController::class, 'edit'])->name('edit');
        Route::put('/{submission}', [SubmissionController::class, 'update'])->name('update');
    });
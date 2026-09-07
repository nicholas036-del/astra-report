<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dealer\SubmissionController;
use App\Http\Controllers\Dealer\TaskController as DealerTaskController;
use App\Http\Controllers\Supervisor\AreaController;
use App\Http\Controllers\Supervisor\DealerController;
use App\Http\Controllers\Supervisor\DepartmentController;
use App\Http\Controllers\Supervisor\ReviewController;
use App\Http\Controllers\Supervisor\TaskController as SupervisorTaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:supervisor')->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::resource('dealers', DealerController::class)->except('show');
        Route::resource('departments', DepartmentController::class)->except('show');
        Route::resource('areas', AreaController::class)->except('show');
        Route::resource('tasks', SupervisorTaskController::class)->except('show');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{submission}', [ReviewController::class, 'show'])->name('reviews.show');
        Route::put('reviews/{submission}', [ReviewController::class, 'update'])->name('reviews.update');
    });

    Route::middleware('role:dealer')->prefix('dealer')->name('dealer.')->group(function () {
        Route::get('tasks', [DealerTaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/{task}', [DealerTaskController::class, 'show'])->name('tasks.show');
        Route::post('tasks/{task}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    });
});

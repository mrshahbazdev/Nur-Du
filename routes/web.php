<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DecisionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuarterlyFocusController;
use App\Http\Controllers\VisionCheckController;
use App\Http\Controllers\VisionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Vision
    Route::get('/vision', [VisionController::class, 'index'])->name('vision.index');
    Route::post('/vision', [VisionController::class, 'store'])->name('vision.store');
    Route::post('/vision/principles', [VisionController::class, 'storePrinciple'])->name('vision.principles.store');
    Route::put('/vision/principles/{principle}', [VisionController::class, 'updatePrinciple'])->name('vision.principles.update');
    Route::delete('/vision/principles/{principle}', [VisionController::class, 'destroyPrinciple'])->name('vision.principles.destroy');

    // Quarterly Focus
    Route::get('/quarterly', [QuarterlyFocusController::class, 'index'])->name('quarterly.index');
    Route::post('/quarterly', [QuarterlyFocusController::class, 'store'])->name('quarterly.store');
    Route::get('/quarterly/{quarterlyFocus}', [QuarterlyFocusController::class, 'show'])->name('quarterly.show');
    Route::delete('/quarterly/{quarterlyFocus}', [QuarterlyFocusController::class, 'destroy'])->name('quarterly.destroy');
    Route::post('/quarterly/{quarterlyFocus}/priorities', [QuarterlyFocusController::class, 'storePriority'])->name('quarterly.priorities.store');
    Route::put('/priorities/{priority}', [QuarterlyFocusController::class, 'updatePriority'])->name('priorities.update');
    Route::delete('/priorities/{priority}', [QuarterlyFocusController::class, 'destroyPriority'])->name('priorities.destroy');

    // Decisions
    Route::get('/decisions', [DecisionController::class, 'index'])->name('decisions.index');
    Route::get('/decisions/create', [DecisionController::class, 'create'])->name('decisions.create');
    Route::post('/decisions', [DecisionController::class, 'store'])->name('decisions.store');
    Route::get('/decisions/{decision}/edit', [DecisionController::class, 'edit'])->name('decisions.edit');
    Route::put('/decisions/{decision}', [DecisionController::class, 'update'])->name('decisions.update');
    Route::delete('/decisions/{decision}', [DecisionController::class, 'destroy'])->name('decisions.destroy');

    // Vision Checks
    Route::get('/checks', [VisionCheckController::class, 'index'])->name('checks.index');
    Route::get('/checks/create', [VisionCheckController::class, 'create'])->name('checks.create');
    Route::post('/checks', [VisionCheckController::class, 'store'])->name('checks.store');
    Route::get('/checks/{check}', [VisionCheckController::class, 'show'])->name('checks.show');
    Route::delete('/checks/{check}', [VisionCheckController::class, 'destroy'])->name('checks.destroy');
    Route::patch('/action-items/{actionItem}/toggle', [VisionCheckController::class, 'toggleActionItem'])->name('action-items.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

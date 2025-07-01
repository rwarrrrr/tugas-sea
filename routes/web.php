<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/contacts', [ContactController::class, 'dashboard'])->name('contacts.dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');
        Route::get('/dashboard/data', [DashboardController::class, 'dataAdmin'])->name('admin.dashboard.data');

        Route::get('/plans/data', [PlanController::class, 'data'])->name('plans.data');
        Route::post('/plans/bulk-delete', [PlanController::class, 'bulkDelete'])->name('plans.bulkDelete');
        Route::post('/plans/bulk-status', [PlanController::class, 'bulkStatus'])->name('plans.bulkStatus');
        Route::get('/plans/export-excel', [PlanController::class, 'export'])->name('plans.exportExcel');
        Route::get('/plans/export-pdf', [PlanController::class, 'exportPdf'])->name('plans.exportPdf');
        Route::resource('plans', PlanController::class)->except(['show']);
        
        Route::get('/users/data', [UserManagementController::class, 'data'])->name('users.data');
        Route::post('/users/bulk-delete', [UserManagementController::class, 'bulkDelete'])->name('users.bulkDelete');
        Route::post('/users/reset-password/{user}', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('users', UserManagementController::class)->except(['show']);

        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    });
    
    Route::middleware([UserMiddleware::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
        
        Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
        Route::post('/subscription/pause/{id}', [SubscriptionController::class, 'pause'])->name('subscription.pause');
        Route::post('/subscription/resume/{id}', [SubscriptionController::class, 'resume'])->name('subscription.resume');
        Route::post('/subscription/cancel/{id}', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
        Route::post('/subscription/{id}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
        Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
        
        Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

    });

});

require __DIR__.'/auth.php';

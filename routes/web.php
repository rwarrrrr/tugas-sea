<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PlanController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/menu', 'pages.menu');
Route::view('/subscription', 'pages.subscription');
Route::view('/contact', 'pages.contact');

Route::middleware('auth')->group(function () {

    Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin-dashboard');
        })->middleware(['auth', 'verified'])->name('admin.dashboard');

        Route::get('/plans/data', [PlanController::class, 'data'])->name('plans.data');
        Route::post('/plans/bulk-delete', [PlanController::class, 'bulkDelete'])->name('plans.bulkDelete');
        Route::post('/plans/bulk-status', [PlanController::class, 'bulkStatus'])->name('plans.bulkStatus');
        Route::get('/plans/export-excel', [PlanController::class, 'export'])->name('plans.exportExcel');
        Route::get('/plans/export-pdf', [PlanController::class, 'exportPdf'])->name('plans.exportPdf');
        Route::resource('plans', PlanController::class)->except(['show']);
    });
    
    Route::middleware([UserMiddleware::class])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
        
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    });

});

require __DIR__.'/auth.php';

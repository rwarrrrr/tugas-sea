<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\TestimonialController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/menu', 'pages.menu');
Route::view('/subscription', 'pages.subscription');
Route::view('/contact', 'pages.contact');

Route::middleware('auth')->group(function () {

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin-dashboard');
        })->middleware(['auth', 'verified'])->name('admin.dashboard');
    });
    
    Route::middleware([UserMiddleware::class])->group(function () {
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
    });

});

require __DIR__.'/auth.php';

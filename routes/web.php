<?php

use App\Http\Controllers\RestaurantDirectoryController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            return Inertia::render('Home');
        })->name('home');
    });
}

Route::get('/register-restaurant', [TenantRegistrationController::class, 'create'])
    ->name('tenant.register');

Route::post('/register-restaurant', [TenantRegistrationController::class, 'store'])
    ->name('tenant.register.store');

Route::get('/restaurants', [RestaurantDirectoryController::class, 'index'])
    ->name('restaurants.index');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

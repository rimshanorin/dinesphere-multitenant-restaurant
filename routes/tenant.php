<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\MenuItemController;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Public storefront
    Route::get('/', function () {
        return Inertia::render('Tenant/Storefront', [
            'restaurantName' => tenant('name'),
            'menuItems' => MenuItem::latest()->get(),
        ]);
    })->name('tenant.home');

    // Guest-only auth routes (login/register for THIS tenant)
    Route::middleware('guest')->group(function () {
        // Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        // Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    });

    // Authenticated routes (dashboard + menu management)
    Route::middleware('auth')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')->name('verification.send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/dashboard', [MenuItemController::class, 'index'])->name('tenant.dashboard');
        Route::post('/dashboard/menu-items', [MenuItemController::class, 'store'])->name('tenant.menu.store');
        Route::put('/dashboard/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('tenant.menu.update');
        Route::delete('/dashboard/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('tenant.menu.destroy');
    });
});

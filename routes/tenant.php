<?php

declare(strict_types=1);

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

    Route::get('/', function () {
        return Inertia::render('Tenant/Storefront', [
            'restaurantName' => tenant('name'),
            'menuItems' => MenuItem::latest()->get(),
        ]);
    })->name('tenant.home');

    Route::get('/dashboard', [MenuItemController::class, 'index'])->name('tenant.dashboard');
    Route::post('/dashboard/menu-items', [MenuItemController::class, 'store'])->name('tenant.menu.store');
    Route::put('/dashboard/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('tenant.menu.update');
    Route::delete('/dashboard/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('tenant.menu.destroy');
});

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| These routes only load when a request comes from a registered
| tenant domain (e.g. lapiazza.dinesphere.test).
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Tenant-specific routes will go here once we create tenants.
    // Example (added later):
    // Route::get('/', [TenantHomeController::class, 'index']);
});

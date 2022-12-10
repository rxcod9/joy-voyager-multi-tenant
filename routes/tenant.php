<?php

declare(strict_types=1);

use App\Facades\TenantVoyager;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group([
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ]
], function () {

    Route::get('/', ['uses' => '\App\Http\Controllers\Tenant\IndexController@welcome', 'as' => 'tenant-home']);

    Route::group(['prefix' => 'admin'], function () {
        TenantVoyager::routes();
    });
});

<?php

use App\Modules\Storefront\Customer\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Storefront\Customer\Interface\Http\Middleware\EnsureCustomerToken;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/storefront', 'as' => 'api.v1.storefront.'], static function () {
    // Auth
    Route::group(['prefix' => 'customers', 'as' => 'customers.'], static function () {
        Route::post('/login', [AbstractAuthController::class, 'login'])->name('login');
        Route::post('/register', [AbstractAuthController::class, 'register'])->name('register');

        Route::middleware([EnsureCustomerToken::class, 'auth:sanctum','auth:customer', 'ability:customer'])->group(static function () {
            Route::post('/logout', [AbstractAuthController::class, 'logout'])->name('logout');
        });
    });
});




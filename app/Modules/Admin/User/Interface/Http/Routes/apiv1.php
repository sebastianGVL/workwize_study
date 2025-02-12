<?php

use App\Modules\Admin\User\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Admin\User\Domain\Http\Controllers\AbstractUserCustomerController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/admin', 'as' => 'api.v1.admin.'], static function () {
    // Auth
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], static function () {
        Route::post('/login', [AbstractAuthController::class, 'login'])->name('login');
        Route::post('/register', [AbstractAuthController::class, 'register'])->name('register');

        Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], static function () {
            Route::post('/logout', [AbstractAuthController::class, 'logout'])->name('logout');
        });
    });

    Route::group(['middleware' => ['auth:sanctum', 'ability:admin'], 'prefix' => 'users/{userId}/customers', 'as' => 'users.customers.'], static function () {
        Route::get('', [AbstractUserCustomerController::class, 'index'])->name('index');
    });
});




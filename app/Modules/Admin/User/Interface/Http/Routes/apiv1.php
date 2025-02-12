<?php

use App\Modules\Admin\User\Interface\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/admin', 'as' => 'api.v1.admin.'], static function () {
    // Auth
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], static function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::group(['middleware' => ['auth:sanctum']], static function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });
    });

    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'account', 'as' => 'account.'], static function () {
//        Route::get('/user', [AccountController::class, 'show'])->name('user');
    });
});




<?php

use App\Modules\Storefront\Cart\Domain\Http\Controllers\AbstractCartController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/storefront/customers/{customerId}/', 'as' => 'api.v1.storefront.'], static function () {
    Route::group(['prefix' => 'carts', 'as' => 'carts.', 'middleware' => ['auth:sanctum', 'ability:customer']], static function () {
        Route::get('show', [AbstractCartController::class, 'show'])->name('show');
        Route::post('add', [AbstractCartController::class, 'add'])->name('add');
        Route::post('remove', [AbstractCartController::class, 'remove'])->name('remove');
        Route::post('update', [AbstractCartController::class, 'update'])->name('update');
    });
});

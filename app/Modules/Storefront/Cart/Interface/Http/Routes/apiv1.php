<?php

use App\Modules\Storefront\Cart\Domain\Http\Controllers\AbstractCartController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/storefront/users/{userId}/', 'as' => 'api.v1.storefront.'], static function () {
    Route::group(['prefix' => 'carts', 'as' => 'carts.'], static function () {
        Route::get('show', [AbstractCartController::class, 'show'])->name('cart.show');
        Route::post('add', [AbstractCartController::class, 'add'])->name('cart.add');
        Route::post('remove', [AbstractCartController::class, 'remove'])->name('cart.remove');
        Route::post('update', [AbstractCartController::class, 'update'])->name('cart.decrement-quantity');
    });
});

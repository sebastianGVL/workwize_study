<?php

use App\Modules\Storefront\Order\Domain\Http\Controllers\AbstractOrderController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/storefront/customers/{customerId}/', 'as' => 'api.v1.storefront.'], static function () {
    Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => ['auth:sanctum', 'ability:customer']], static function () {
        Route::get('', [AbstractOrderController::class, 'index'])->name('index');
        Route::post('store', [AbstractOrderController::class, 'store'])->name('store');
    });
});

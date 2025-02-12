<?php

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractShowAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractStoreAction;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/admin', 'as' => 'api.v1.admin.'], static function () {
    // Auth
    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => '/users/{userId}/products', 'as' => 'users.products.'], static function () {
        Route::post('store', AbstractStoreAction::class)->name('store');
        Route::get('show/{id}', AbstractShowAction::class)->name('show');
//        Route::put('update/{id}', UpdateAction::class)->name('update');
//        Route::delete('delete/{id}', DeleteAction::class)->name('delete');
    });
});




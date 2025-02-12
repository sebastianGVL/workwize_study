<?php

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractDeleteAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractShowAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractStoreAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractUpdateAction;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/admin', 'as' => 'api.v1.admin.'], static function () {
    // PRODUCT CRUD
    Route::group(['middleware' => ['auth:sanctum', 'ability:admin'], 'prefix' => '/users/{userId}/products', 'as' => 'users.products.'], static function () {
        Route::post('store', AbstractStoreAction::class)->name('store');
        Route::get('show/{id}', AbstractShowAction::class)->name('show');
        Route::put('update/{id}', AbstractUpdateAction::class)->name('update');
        Route::delete('delete/{id}', AbstractDeleteAction::class)->name('delete');
    });
});




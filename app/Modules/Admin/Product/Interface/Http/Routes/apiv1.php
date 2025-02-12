<?php

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractDeleteAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractIndexAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractShowAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractStoreAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractUpdateAction;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/admin', 'as' => 'api.v1.admin.'], static function () {
    // PRODUCT CRUD
    Route::group(['middleware' => ['auth:sanctum', 'ability:admin'], 'prefix' => '/users/{userId}/products', 'as' => 'users.products.'], static function () {
        Route::post('store', AbstractStoreAction::class)->name('store');
        Route::get('', AbstractIndexAction::class)->name('index');
        Route::get('{id}/show', AbstractShowAction::class)->name('show');
        Route::put('{id}/update', AbstractUpdateAction::class)->name('update');
        Route::delete('{id}/delete', AbstractDeleteAction::class)->name('delete');
    });
});




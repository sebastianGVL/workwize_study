<?php

use App\Modules\Storefront\Product\Domain\Http\Controllers\AbstractProductListingAction;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1/storefront', 'as' => 'api.v1.storefront.'], static function () {
    Route::group(['prefix' => 'products', 'as' => 'products.'], static function () {
        Route::get('', AbstractProductListingAction::class)->name('listing');
    });
});

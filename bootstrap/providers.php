<?php

use App\Modules\Admin\Product\Providers\ProductServiceProvider;
use App\Modules\Admin\User\Providers\UserServiceProvider;
use App\Modules\Common\Providers\AppServiceProvider;
use App\Modules\Storefront\Cart\Providers\CartServiceProvider as StorefrontCartServiceProviderAlias;
use App\Modules\Storefront\Customer\Providers\CustomerServiceProvider as StorefrontCustomerServiceProvider;
use App\Modules\Storefront\Product\Providers\ProductServiceProvider as StorefrontProductServiceProvider;

return [
    AppServiceProvider::class,
    UserServiceProvider::class,
    ProductServiceProvider::class,

    StorefrontCustomerServiceProvider::class,
    StorefrontProductServiceProvider::class,
    StorefrontCartServiceProviderAlias::class,
];

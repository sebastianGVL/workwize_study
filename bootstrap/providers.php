<?php

use App\Modules\Admin\Product\Providers\ProductServiceProvider;
use App\Modules\Admin\User\Providers\UserServiceProvider;
use App\Modules\Common\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    UserServiceProvider::class,
    ProductServiceProvider::class,
];

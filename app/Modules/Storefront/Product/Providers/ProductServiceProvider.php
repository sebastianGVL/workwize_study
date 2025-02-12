<?php

namespace App\Modules\Storefront\Product\Providers;

use App\Modules\Storefront\Product\Domain\Http\Controllers\AbstractProductListingAction;
use App\Modules\Storefront\Product\Interface\Http\Controllers\ProductListingAction;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Interface
        $this->app->bind(AbstractProductListingAction::class, ProductListingAction::class);

    }

    public function boot(): void
    {
        if(file_exists($this->getRoutePath()))
        {
            $this->loadRoutesFrom($this->getRoutePath());
        }
    }

    private function getRoutePath(string $filename = 'apiv1.php'): string
    {
        return __DIR__ . "/../Interface/Http/Routes/$filename";
    }
}

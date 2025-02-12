<?php

namespace App\Modules\Storefront\Order\Providers;

use App\Modules\Storefront\Order\Domain\Http\Controllers\AbstractOrderController;
use App\Modules\Storefront\Order\Domain\Http\Requests\AbstractOrderStoreRequest;
use App\Modules\Storefront\Order\Interface\Http\Controllers\OrderController;
use App\Modules\Storefront\Order\Interface\Http\Requests\OrderStoreRequest;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Interface
        $this->app->bind(AbstractOrderController::class, OrderController::class);
        $this->app->bind(AbstractOrderStoreRequest::class, OrderStoreRequest::class);
    }
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Persistence/Migrations');

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

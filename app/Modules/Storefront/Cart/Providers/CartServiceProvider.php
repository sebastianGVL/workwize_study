<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Cart\Providers;

use App\Modules\Storefront\Cart\Application\Services\CartAddProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartRemoveProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartUpdateProcessor;
use App\Modules\Storefront\Cart\Domain\Http\Controllers\AbstractCartController;
use App\Modules\Storefront\Cart\Domain\Services\CartAddProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartRemoveProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartUpdateProcessorInterface;
use App\Modules\Storefront\Cart\Interface\Http\Controllers\CartController;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Application
        $this->app->bind(CartAddProcessorInterface::class, CartAddProcessor::class);
        $this->app->bind(CartUpdateProcessorInterface::class, CartUpdateProcessor::class);
        $this->app->bind(CartRemoveProcessorInterface::class, CartRemoveProcessor::class);

        // Interface
        $this->app->bind(AbstractCartController::class, CartController::class);
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

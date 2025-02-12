<?php

namespace App\Modules\Admin\Product\Providers;

use App\Modules\Admin\Product\Application\Services\ShowService;
use App\Modules\Admin\Product\Application\Services\StoreService;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractShowAction;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractStoreAction;
use App\Modules\Admin\Product\Domain\Http\Requests\AbstractShowRequest;
use App\Modules\Admin\Product\Domain\Http\Requests\AbstractStoreRequest;
use App\Modules\Admin\Product\Domain\Services\AbstractStoreService;
use App\Modules\Admin\Product\Domain\Services\ShowServiceInterface;
use App\Modules\Admin\Product\Interface\Http\Controllers\ShowAction;
use App\Modules\Admin\Product\Interface\Http\Controllers\StoreAction;
use App\Modules\Admin\Product\Interface\Http\Requests\ShowRequest;
use App\Modules\Admin\Product\Interface\Http\Requests\StoreRequest;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Interface
        $this->app->bind(AbstractStoreRequest::class, StoreRequest::class);
        $this->app->bind(AbstractShowRequest::class, ShowRequest::class);

        $this->app->bind(AbstractShowAction::class, ShowAction::class);
        $this->app->bind(AbstractStoreAction::class, StoreAction::class);

        //Application
        $this->app->bind(AbstractStoreService::class, StoreService::class);
        $this->app->bind(ShowServiceInterface::class, ShowService::class);

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

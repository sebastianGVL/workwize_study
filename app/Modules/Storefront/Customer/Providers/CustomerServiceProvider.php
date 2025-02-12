<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Providers;

use App\Modules\Storefront\Customer\Application\Services\AuthService;
use App\Modules\Storefront\Customer\Application\Services\RegistrationService;
use App\Modules\Storefront\Customer\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractRegisterRequest;
use App\Modules\Storefront\Customer\Domain\Services\AuthServiceInterface;
use App\Modules\Storefront\Customer\Domain\Services\RegistrationServiceInterface;
use App\Modules\Storefront\Customer\Interface\Http\Controllers\AuthController;
use App\Modules\Storefront\Customer\Interface\Http\Requests\LoginRequest;
use App\Modules\Storefront\Customer\Interface\Http\Requests\RegisterRequest;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Interface
        $this->app->bind(AbstractRegisterRequest::class, RegisterRequest::class);
        $this->app->bind(AbstractLoginRequest::class, LoginRequest::class);
        $this->app->bind(AbstractAuthController::class, AuthController::class);

        //Application
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(RegistrationServiceInterface::class, RegistrationService::class);
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

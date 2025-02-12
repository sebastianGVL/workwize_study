<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Providers;

use App\Modules\Admin\User\Application\Services\AuthService;
use App\Modules\Admin\User\Application\Services\RegistrationService;
use App\Modules\Admin\User\Domain\Http\Controllers\AbstractAuthController;
use App\Modules\Admin\User\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Admin\User\Domain\Http\Requests\AbstractRegisterRequest;
use App\Modules\Admin\User\Domain\Services\AuthServiceInterface;
use App\Modules\Admin\User\Domain\Services\RegistrationServiceInterface;
use App\Modules\Admin\User\Interface\Http\Controllers\AuthController;
use App\Modules\Admin\User\Interface\Http\Requests\LoginRequest;
use App\Modules\Admin\User\Interface\Http\Requests\RegisterRequest;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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

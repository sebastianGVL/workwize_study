<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Domain\Services;

use App\Modules\Storefront\Customer\Application\Data\LoginData;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    public function login(LoginData $data): ?Authenticatable;

    public function logout(): void;
}

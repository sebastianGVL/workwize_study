<?php

namespace App\Modules\Admin\User\Domain\Services;

use App\Modules\Admin\User\Application\Data\LoginData;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    public function login(LoginData $data): ?Authenticatable;

    public function logout(): void;
}

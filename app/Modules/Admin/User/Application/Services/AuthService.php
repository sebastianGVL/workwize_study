<?php

namespace App\Modules\Admin\User\Application\Services;

use App\Modules\Admin\User\Application\Data\LoginData;
use App\Modules\Admin\User\Domain\Models\User;
use App\Modules\Admin\User\Domain\Services\AuthServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function login(LoginData $data): ?User
    {
        $loginSuccess = Auth::attempt(['email' => $data->email, 'password' => $data->password]);
        $user = User::query()->where('email', $data->email)->first();
        assert($user instanceof User|null);

        return (!$user instanceof Authenticatable || !$loginSuccess) ? null : $user;
    }

    public function logout(): void
    {
        $user = Auth::user();

        $user?->tokens()?->delete();
    }
}

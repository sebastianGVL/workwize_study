<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Application\Services;

use App\Modules\Storefront\Customer\Application\Data\LoginData;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Customer\Domain\Services\AuthServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function login(LoginData $data): ?Customer
    {
        $loginSuccess = Auth::guard('customer')
            ->attempt(
                [
                    'email' => $data->email,
                    'password' => $data->password
                ]);

        $customer = Customer::query()->where('email', $data->email)->first();
        assert($customer instanceof Customer | null);

        return (!$customer instanceof Authenticatable || !$loginSuccess) ? null : $customer;
    }

    public function logout(): void
    {
        $customer = Auth::user();

        $customer?->tokens()?->delete();
    }
}

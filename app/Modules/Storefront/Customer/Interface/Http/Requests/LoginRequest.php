<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Interface\Http\Requests;

use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractLoginRequest;

class LoginRequest extends AbstractLoginRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6']
        ];
    }
}

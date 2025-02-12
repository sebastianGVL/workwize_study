<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Interface\Http\Requests;

use App\Modules\Admin\User\Domain\Http\Requests\AbstractLoginRequest;

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

<?php

namespace App\Modules\Admin\User\Interface\Http\Requests;

use App\Modules\Admin\User\Domain\Http\Requests\AbstractRegisterRequest;

class RegisterRequest extends AbstractRegisterRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }
}

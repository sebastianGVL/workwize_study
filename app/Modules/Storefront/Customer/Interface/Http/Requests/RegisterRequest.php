<?php

namespace App\Modules\Storefront\Customer\Interface\Http\Requests;


use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractRegisterRequest;

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
            'email' => ['required', 'string', 'email', 'unique:customers', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }
}

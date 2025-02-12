<?php

namespace App\Modules\Storefront\Customer\Application\Data;


use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractRegisterRequest;

readonly class RegistrationData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {
    }

    public static function fromRequest(AbstractRegisterRequest $request): self
    {
        return new self(
            name: $request->string('name'),
            email: $request->string('email'),
            password: $request->string('password'),
        );
    }
}

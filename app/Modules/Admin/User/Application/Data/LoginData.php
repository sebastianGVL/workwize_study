<?php

namespace App\Modules\Admin\User\Application\Data;

use App\Modules\Admin\User\Domain\Http\Requests\AbstractLoginRequest;

readonly class LoginData
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
    }

    public static function fromRequest(AbstractLoginRequest $request): self
    {
        return new self(
            email: $request->string('email'),
            password: $request->string('password'),
        );
    }
}

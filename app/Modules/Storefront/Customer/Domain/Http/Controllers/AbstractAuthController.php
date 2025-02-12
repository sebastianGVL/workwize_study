<?php

namespace App\Modules\Storefront\Customer\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Storefront\Customer\Domain\Http\Requests\AbstractRegisterRequest;
use Illuminate\Http\JsonResponse;

abstract class AbstractAuthController extends Controller
{
    abstract public function login(AbstractLoginRequest $request): JsonResponse;

    abstract  public function register(AbstractRegisterRequest $request): JsonResponse;

    abstract  public function logout(): JsonResponse;
}

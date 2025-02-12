<?php

namespace App\Modules\Admin\User\Domain\Http\Controllers;

use App\Modules\Admin\User\Domain\Http\Requests\AbstractLoginRequest;
use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class AbstractAuthController extends Controller
{
    abstract public function login(AbstractLoginRequest $request): JsonResponse;
}

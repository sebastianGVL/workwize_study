<?php

namespace App\Modules\Storefront\Cart\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use App\Modules\Storefront\Cart\Application\Services\CartAddProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartRemoveProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartUpdateProcessor;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractAddRequest;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractRemoveRequest;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractUpdateRequest;
use Illuminate\Http\JsonResponse;

abstract class AbstractCartController extends Controller
{
   abstract public function add(AbstractAddRequest $request,int $customerId, CartAddProcessor $processor): JsonResponse;

   abstract public function remove(AbstractRemoveRequest $request,int $customerId, CartRemoveProcessor $processor): JsonResponse;

   abstract public function update(AbstractUpdateRequest $request,int $customerId, CartUpdateProcessor $processor): JsonResponse;

   abstract public function show(int $customerId): JsonResponse;
}

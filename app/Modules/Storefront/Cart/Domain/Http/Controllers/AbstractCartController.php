<?php

namespace App\Modules\Storefront\Cart\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use App\Modules\Storefront\Cart\Application\Services\CartAddProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartRemoveProcessor;
use App\Modules\Storefront\Cart\Application\Services\CartUpdateProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractCartController extends Controller
{
   abstract public function add(Request $request,int $customerId, CartAddProcessor $processor): JsonResponse;

   abstract public function remove(Request $request,int $customerId, CartRemoveProcessor $processor): JsonResponse;

   abstract public function update(Request $request,int $customerId, CartUpdateProcessor $processor): JsonResponse;

   abstract public function show(int $customerId): JsonResponse;
}

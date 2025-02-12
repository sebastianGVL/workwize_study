<?php

namespace App\Modules\Storefront\Order\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use App\Modules\Storefront\Order\Application\Services\OrderCartValidationService;
use App\Modules\Storefront\Order\Application\Services\OrderStoreService;
use App\Modules\Storefront\Order\Interface\Http\Requests\OrderStoreRequest;
use Illuminate\Http\JsonResponse;

abstract class AbstractOrderController extends Controller
{
    abstract public function index(int $customerId): JsonResponse;

    abstract public function store(OrderStoreRequest $request, int $customerId, OrderCartValidationService $cartValidationService, OrderStoreService $storeService): JsonResponse;
}

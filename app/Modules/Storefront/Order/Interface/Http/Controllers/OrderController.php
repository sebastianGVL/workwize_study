<?php

namespace App\Modules\Storefront\Order\Interface\Http\Controllers;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Order\Application\Data\OrderStoreData;
use App\Modules\Storefront\Order\Application\Services\OrderCartValidationService;
use App\Modules\Storefront\Order\Application\Services\OrderStoreService;
use App\Modules\Storefront\Order\Domain\Http\Controllers\AbstractOrderController;
use App\Modules\Storefront\Order\Domain\Http\Requests\AbstractOrderStoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractOrderController
{
    public function index(int $customerId): JsonResponse
    {
        /** @var Customer $customer */
        $customer = Auth::user()->load(['orders.lines']);

        if($customerId !== $customer->id) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'unauthorized'),
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'orders' => $customer->orders
                ],
                'success'
            ),
            status: Response::HTTP_CREATED
        );
    }

    public function store(AbstractOrderStoreRequest $request, int $customerId, OrderCartValidationService $cartValidationService, OrderStoreService $storeService): JsonResponse
    {
        $customer = Auth::user();

        if($customerId !== $customer->id) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'unauthorized'),
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $cartValidationService->validateCartContent();

            $order = $storeService->store(OrderStoreData::fromRequest($request), Auth::user());
        } catch (\Throwable $e) {
            Log::info('OrderController::store failed: ' . $e->getMessage(), ['customerId' => $customerId, 'data' => $request->toArray()]);
            dd($e->getMessage());
            return response()->json(
                data: BaseApiResponseData::make(null, 'could not create order'),
                status: Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json(
          data: BaseApiResponseData::make(
              [
                  'order' => [
                      'id' => $order->id,
                      'customer_id' => $order->customer_id,
                      'customer_name' => $order->customer_name,
                      'customer_email' => $order->customer_email,
                      'created_at' => $order->created_at->toDateString(),
                      'lines' => $order->lines,
                  ]
              ],
              'success'
            ),
            status: Response::HTTP_CREATED
        );
    }
}

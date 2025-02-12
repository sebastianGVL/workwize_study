<?php

namespace App\Modules\Storefront\Cart\Interface\Http\Controllers;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use App\Modules\Storefront\Cart\Domain\Http\Controllers\AbstractCartController;
use App\Modules\Storefront\Cart\Domain\Services\CartAddProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartRemoveProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartUpdateProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractCartController
{
    public function add(Request $request,int $customerId, CartAddProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::guard('customer')->id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $cart = $processor->add(
                $request->input('productNumber'),
                $request->input('quantity') ?: 1
            );

        } catch (\Throwable $e) {
            Log::error(
                'CartController::add failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::guard('customer')->id()]
            );

            $cart = Customer::getCart();
        }

        $cart->refresh();
        $subtotal = $cart->getTotal('subtotal');
        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'cart' => [
                        'items' => $cart->items,
                        'subtotal' => $subtotal,
                        'total' => $cart->getTotal('total', $subtotal),
                    ]
                ],
                'success'
            )
        );
    }

    public function remove(Request $request,int $customerId, CartRemoveProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::guard('customer')->id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $cart = $processor->remove($request->input('productNumber'));
        } catch (\Throwable $e) {
            Log::error(
                'CartController::remove failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::guard('customer')->id()]
            );

            $cart = Customer::getCart();
        }


        $cart->refresh();
        $subtotal = $cart->getTotal('subtotal');

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'cart' => [
                        'items' => $cart->items,
                        'subtotal' => $subtotal,
                        'total' => $cart->getTotal('total', $subtotal),
                    ]
                ],
                'success'
            )
        );
    }

    public function update(Request $request,int $customerId, CartUpdateProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::guard('customer')->id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $cart = $processor->update(
                $request->input('productNumber'),
                $request->input('quantity') ?: 1
            );
        } catch (\Throwable $e) {
            Log::error(
                'CartController::decrementQuantity failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::guard('customer')->id()]
            );

            $cart = Customer::getCart();
        }

        $cart->refresh();
        $subtotal = $cart->getTotal('subtotal');

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'cart' => [
                        'items' => $cart->items,
                        'subtotal' => $subtotal,
                        'total' => $cart->getTotal('total', $subtotal),
                    ]
                ],
                'success'
            )
        );
    }

    public function show(int $customerId): JsonResponse
    {
        if ($customerId !== Auth::guard('customer')->id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        $cart = Customer::getCart();
        $subtotal = $cart->getTotal('subtotal');

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'cart' => [
                        'items' => $cart->items,
                        'subtotal' => $subtotal,
                        'total' => $cart->getTotal('total', $subtotal),
                    ]
                ],
                'success'
            )
        );
    }
}

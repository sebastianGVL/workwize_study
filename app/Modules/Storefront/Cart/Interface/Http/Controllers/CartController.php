<?php

namespace App\Modules\Storefront\Cart\Interface\Http\Controllers;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use App\Modules\Storefront\Cart\Domain\Http\Controllers\AbstractCartController;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractAddRequest;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractRemoveRequest;
use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractUpdateRequest;
use App\Modules\Storefront\Cart\Domain\Services\CartAddProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartRemoveProcessorInterface;
use App\Modules\Storefront\Cart\Domain\Services\CartUpdateProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractCartController
{
    public function add(AbstractAddRequest $request,int $customerId, CartAddProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        $errors = [];

        try {
            $processor->add(
                $request->input('productId'),
                $request->input('quantity') ?: 1
            );

        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        } catch (\Throwable $e) {
            Log::error(
                'CartController::add failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::id()]
            );
        }

        $cart = Customer::getCart(Auth::id());

        $cart->refresh();
        $subtotal = $cart->getTotal('subtotal');

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'cart' => [
                        'items' => $cart->items,
                        'subtotal' => $subtotal,
                        'total' => $cart->getTotal('total', $subtotal),
                    ],
                    'errors' => $errors,
                ],
                'success'
            )
        );
    }

    public function remove(AbstractRemoveRequest $request,int $customerId, CartRemoveProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        $errors = [];

        try {
            $cart = $processor->remove($request->input('productId'));
        } catch (\Throwable $e) {
            Log::error(
                'CartController::remove failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::id()]
            );

            $errors[] = $e->getMessage();
            $cart = Customer::getCart(Auth::id());
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
                    ],
                    'errors' => $errors,
                ],
                'success'
            )
        );
    }

    public function update(AbstractUpdateRequest $request,int $customerId, CartUpdateProcessorInterface $processor): JsonResponse
    {
        if ($customerId !== Auth::id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $cart = $processor->update(
                $request->input('productId'),
                $request->input('quantity') !== null ? $request->input('quantity') : 1
            );
        } catch (\Throwable $e) {
            dd($e->getMessage());
            Log::error(
                'CartController::decrementQuantity failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'customerId' => Auth::id()]
            );

            $cart = Customer::getCart(Auth::id());
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
        if ($customerId !== Auth::id()){
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        $cart = Customer::getCart(Auth::id());
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

<?php

namespace App\Modules\Storefront\Order\Application\Services;

use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderCartValidationService
{
    public function validateCartContent(): void
    {
        $cart = Customer::getCart(Auth::id());

        $items = array_unique($cart->items()->pluck('product_id')->toArray());

        $productsCount = Product::query()
            ->whereIn('id', $items)
            ->whereNot('stock', 0)
            ->count();

        if (count($items) !== $productsCount) {
            $cart->items()->delete();
            throw ValidationException::withMessages(['cart' => 'some_products_sold']);
        }
    }
}

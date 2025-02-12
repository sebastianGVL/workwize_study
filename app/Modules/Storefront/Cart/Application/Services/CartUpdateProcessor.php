<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartUpdateProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;

class CartUpdateProcessor extends AbstractBaseCartProcessor implements CartUpdateProcessorInterface
{
    public function update(string $productNumber, int $quantity): Cart
    {
        $product = $this->fetchProduct($productNumber);
        $cart = Customer::getCart();
        $item = $cart->items()->where('product_number', $productNumber)->first();

        if ($item === null) {
            return $cart;
        }

        return $this->handle($product, $item->quantity - $quantity, $cart, $item);
    }

    protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart
    {
        if ($item === null) {
            return $cart;
        }

        $item->update(
            [
                'quantity' => $quantity,
                'price' => $product->price,
                'total_price' => $product->price * $quantity,
            ]
        );

        return $cart;
    }
}

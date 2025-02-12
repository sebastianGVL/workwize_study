<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartUpdateProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Support\Facades\Auth;

class CartUpdateProcessor extends AbstractBaseCartProcessor implements CartUpdateProcessorInterface
{
    public function update(int $productId, int $quantity): Cart
    {
        $product = $this->fetchProduct($productId);
        $cart = Customer::getCart(Auth::id());
        $item = $cart->items()->where('product_id', $productId)->first();

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

        if (($item->quantity - $quantity) >= $product->stock) {
            $item->update(
                [
                    'quantity' => $product->stock,
                    'price' => $product->price,
                    'total_price' => $product->price * $product->stock,
                ]
            );

            return $cart;
        }

        $item->update(
            [
                'quantity' => $item->quantity - $quantity,
                'price' => $product->price,
                'total_price' => $product->price * ($item->quantity - $quantity),
            ]
        );

        return $cart;
    }
}

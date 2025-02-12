<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartRemoveProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Support\Facades\Auth;

class CartRemoveProcessor extends AbstractBaseCartProcessor implements CartRemoveProcessorInterface
{
    public function remove(int $productId): Cart
    {
        $product = Product::query()->findOrFail($productId);

        $cart = Customer::getCart(Auth::id());

        return $this->handle($product, $product->stock, $cart);
    }

    protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart
    {
        $cart->items()
            ->where('product_id', $product->id)
            ->delete();

        return $cart;
    }
}

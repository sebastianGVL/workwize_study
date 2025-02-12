<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartRemoveProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;

class CartRemoveProcessor extends AbstractBaseCartProcessor implements CartRemoveProcessorInterface
{
    public function remove(string $productNumber): Cart
    {
        $product = new Product();
        $product->product_number = $productNumber;

        $cart = Customer::getCart();

        return $this->handle($product, 1, $cart);
    }

    protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart
    {
        $cart->items()->where('product_number', $product->product_number)->delete();

        return $cart;
    }
}

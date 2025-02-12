<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Validation\ValidationException;

abstract class AbstractBaseCartProcessor
{
    protected function fetchProductAndValidateStock(int $productId): Product
    {
        $product = $this->fetchProduct($productId);

        if ($product->stock === 0) {
            throw ValidationException::withMessages(['quantity' => 'not_in_stock']);
        }

        return $product;
    }

    protected function validateQuantity(int $quantity, Product $product, ?CartItem $item = null): int
    {
        if ($item !== null) {
            $totalQuantity = $quantity + $item->quantity;

            if ($totalQuantity > $product->stock) {
                throw ValidationException::withMessages(['quantity' => 'stock_limit']);
            }

            return $totalQuantity;
        }

        if ($quantity > $product->stock) {
            throw ValidationException::withMessages(['cart' => 'stock_limit']);
        }

        return $quantity;
    }

    protected function fetchProduct(int $productId): Product
    {
        $product = Product::query()->find($productId);

        if ($product === null) {
            throw ValidationException::withMessages(['cart' => 'product_not_found']);
        }

        return $product;
    }

    abstract protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart;
}

<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartAddProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Support\Facades\Log;
use Throwable;

class CartAddProcessor extends AbstractBaseCartProcessor implements CartAddProcessorInterface
{
    public function __construct(private readonly CartUpdateProcessor $updateProcessor)
    {
    }

    public function add(string $productNumber, int $quantity): Cart
    {
        [$cart, $product, $quantity, $itemExists] = $this->validateAdd($productNumber, $quantity);

        try {
            return $this->handle($product, $quantity, $cart, $itemExists);
        } catch (Throwable $e) {
            Log::info('CartAddProcessor::add failed: '.$e->getMessage());

            return $cart;
        }
    }

    protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart
    {
        if ($item !== null) {
            return $this->updateProcessor->handle($product, $quantity, $cart, $item);
        }

        $cart->items()->create([
            'product_number' => $product->product_number,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'total_price' => $product->price * $quantity,
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        return $cart;
    }

    private function validateAdd(string $productNumber, int $quantity): array
    {
        $cart = Customer::getCart();
        $product = $this->fetchProductAndValidateStock($productNumber);
        $item = $cart->items()->where('product_number', $product->product_number)->first();
        $quantity = $this->validateQuantity($quantity, $product, $item);

        return [$cart, $product, $quantity, $item];
    }
}

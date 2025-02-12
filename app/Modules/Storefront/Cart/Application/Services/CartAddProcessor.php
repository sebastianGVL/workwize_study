<?php

namespace App\Modules\Storefront\Cart\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Cart\Domain\Services\CartAddProcessorInterface;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class CartAddProcessor extends AbstractBaseCartProcessor implements CartAddProcessorInterface
{
    public function __construct(private readonly CartUpdateProcessor $updateProcessor)
    {
    }

    public function add(int $productId, int $quantity): Cart
    {
        [$cart, $product, $quantity, $itemExists] = $this->validateAdd($productId, $quantity);
        try {
            return $this->handle($product, $quantity, $cart, $itemExists);
        } catch (Throwable $e) {
            dd($e->getMessage());
            Log::info('CartAddProcessor::add failed: '.$e->getMessage());

            return $cart;
        }
    }

    protected function handle(Product $product, int $quantity, Cart $cart, ?CartItem $item = null): Cart
    {
        if ($item !== null) {
            return $this->updateProcessor->handle($product, 1, $cart, $item);
        }

        $cart->items()->create([
            'product_id' => $product->id,
            'product_number' => $product->product_number,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'total_price' => $product->price * $quantity,
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        return $cart;
    }

    private function validateAdd(int $productId, int $quantity): array
    {
        $cart = Customer::getCart(Auth::id());
        $product = $this->fetchProductAndValidateStock($productId);
        $item = $cart->items()->where('product_number', $product->product_number)->first();
        $quantity = $this->validateQuantity($quantity, $product, $item);

        return [$cart, $product, $quantity, $item];
    }
}

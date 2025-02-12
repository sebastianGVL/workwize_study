<?php

namespace App\Modules\Storefront\Order\Application\Services;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Order\Application\Data\OrderStoreData;
use App\Modules\Storefront\Order\Domain\Models\Order;
use App\Modules\Storefront\Product\Domain\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OrderStoreService
{
    /**
     * @throws Exception
     */
    public function store(OrderStoreData $data, Customer $customer): Order
    {
        $cart = Customer::getCart(Auth::id());

        if ($cart->items()->count() === 0) {
            Log::error('OrderStoreService::create failed', ['cartItems' => $cart->items, 'customer' => $customer]);
            throw new Exception('no cart items');
        }

        return DB::transaction(function () use ($data, $customer, $cart) {
            $order = new Order();

            $order->customer_name = $customer->name;
            $order->customer_email = $customer->email;
            $order->customer_id = $customer->id;

            $order->payment_method = $data->payment_method;
            $order->billing_address = $data->billing_address;
            $order->shipping_address = $data->shipping_address;

            $order->save();

            $this->storeLines($order, $cart);

            $cart->items()->delete();

            return $order;
        });

    }

    private function storeLines(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $cartItem) {
            assert($cartItem instanceof CartItem);

            $product = $this->updateStock($cartItem->product_number, $cartItem->quantity);

            $order->lines()->create([
                'product_id' => $product->id,
                'product_number' => $cartItem->product_number,
                'product_name' => $cartItem->product_name,
                'product_description' => $cartItem->product_description,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total_price' => $cartItem->total_price,
            ]);

            $this->clearItemsFromCarts($product, $cart);
        }
    }

    private function updateStock(string $productNumber, int $quantity): Product
    {
        $product = Product::query()->where('product_number', $productNumber)->first();

        if ($product === null) {
            throw ValidationException::withMessages(['product_not_exists']);
        }

        $product->stock -= $quantity;

        if ($product->stock < 0) {
            $product->stock = 0;
        }

        $product->save();

        return $product;
    }

    private function clearItemsFromCarts(Product $product, Cart $cart): void
    {
        CartItem::query()
            ->where('cart_id', '!=', $cart->id)
            ->where('product_id', $product->id)
            ->delete();
    }
}

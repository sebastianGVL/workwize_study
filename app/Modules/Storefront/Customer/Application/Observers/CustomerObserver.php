<?php

namespace App\Modules\Storefront\Customer\Application\Observers;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Customer\Domain\Models\Customer;

class CustomerObserver
{
    public function created(Customer $customer): void {
        $cart = $customer->cart()->create(['type' => Cart::TYPE_CART]);

        if($cart === null) {
            throw new \Exception('failed to create cart');
        }
    }
}

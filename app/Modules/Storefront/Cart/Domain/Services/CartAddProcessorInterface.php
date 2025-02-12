<?php

namespace App\Modules\Storefront\Cart\Domain\Services;

use App\Modules\Storefront\Cart\Domain\Cart;

interface CartAddProcessorInterface
{
    public function add(int $productId, int $quantity): Cart;
}

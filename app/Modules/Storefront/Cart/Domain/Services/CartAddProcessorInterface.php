<?php

namespace App\Modules\Storefront\Cart\Domain\Services;

use App\Modules\Storefront\Cart\Domain\Cart;

interface CartAddProcessorInterface
{
    public function add(string $productNumber, int $quantity): Cart;
}

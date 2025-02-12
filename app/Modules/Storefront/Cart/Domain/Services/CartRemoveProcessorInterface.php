<?php

namespace App\Modules\Storefront\Cart\Domain\Services;

use App\Modules\Storefront\Cart\Domain\Cart;

interface CartRemoveProcessorInterface
{
    public function remove(int $productId): Cart;
}

<?php

namespace App\Modules\Storefront\Cart\Domain\Services;

use App\Modules\Storefront\Cart\Domain\Cart;

interface CartUpdateProcessorInterface
{
    public function update(int $productId, int $quantity): Cart;
}

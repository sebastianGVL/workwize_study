<?php

namespace App\Modules\Storefront\Cart\Domain\Services;

use App\Modules\Storefront\Cart\Domain\Cart;

interface CartUpdateProcessorInterface
{
    public function update(string $productNumber, int $quantity): Cart;
}

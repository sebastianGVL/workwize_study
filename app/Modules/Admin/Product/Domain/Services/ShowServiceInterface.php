<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Domain\Services;

use App\Modules\Admin\Product\Domain\Models\Product;

interface ShowServiceInterface
{
    public function show(int $productId): Product;
}

<?php

namespace App\Modules\Admin\Product\Application\Services;

use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Admin\Product\Domain\Services\ShowServiceInterface;

class ShowService implements ShowServiceInterface
{
    public function show(int $productId): Product
    {
        return Product::query()->findOrFail($productId);
    }
}

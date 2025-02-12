<?php

namespace App\Modules\Admin\Product\Application\Services;

use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Admin\Product\Domain\Services\AbstractDeleteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DeleteService extends AbstractDeleteService
{

    protected function validate(int $userId, int $productId): void
    {
        if (Auth::id() !== $userId) {
            Log::error('UpdateService::validate user not found', ['productId' => $productId]);
            throw ValidationException::withMessages(['user_id' => 'Invalid user']);
        }

        if (Product::query()->where('id', $productId)->exists() === false) {
            Log::error('UpdateService::validate product not found', ['productId' => $productId]);
            throw ValidationException::withMessages(['product_id' => 'Invalid product']);
        }
    }

    protected function deleteProduct(int $productId): bool
    {
        return Product::query()->where('id', $productId)->delete();
    }
}

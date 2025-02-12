<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Application\Services;

use App\Modules\Admin\Product\Application\Data\UpdateData;
use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Admin\Product\Domain\Services\AbstractUpdateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UpdateService extends AbstractUpdateService
{
    protected function validate(UpdateData $data): void
    {
        if (Auth::id() !== $data->userId) {
            Log::error('UpdateService::validate user not found', ['product' => $data->toArray()]);
            throw ValidationException::withMessages(['user_id' => 'Invalid user']);
        }

        if (!Product::query()->where('id', $data->id)->exists()) {
            Log::error('UpdateService::validate product not found', ['product' => $data->toArray()]);
            throw ValidationException::withMessages(['product_id' => 'Invalid product']);
        }
    }

    protected function updateModel(UpdateData $data): Product
    {
        $product = Product::query()->findOrFail($data->id);

        $product->name = $data->name;
        $product->description = $data->description;
        $product->price = $data->price;
        $product->stock = $data->stock;

        $product->save();

        return $product;
    }
}

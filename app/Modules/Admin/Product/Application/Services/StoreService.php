<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Application\Services;

use App\Modules\Admin\Product\Application\Data\StoreData;
use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Admin\Product\Domain\Services\AbstractStoreService;
use App\Modules\Admin\User\Domain\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StoreService extends AbstractStoreService
{
    protected function validate(StoreData $data): void
    {
        if (Auth::id() !== $data->userId) {
            Log::error('StoreService::validate user not found', ['product' => $data->toArray()]);
            throw ValidationException::withMessages(['user_id' => 'Invalid user']);
        }
    }

    protected function create(StoreData $data): Product
    {
        $product = new Product();

        $product->name = $data->name;
        $product->description = $data->description;
        $product->price = $data->price;
        $product->stock = $data->stock;
        $product->user_id = $data->userId;

        $product->save();

        return $product;
    }
}

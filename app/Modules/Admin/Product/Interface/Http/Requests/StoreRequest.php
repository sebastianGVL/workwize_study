<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Interface\Http\Requests;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractStoreRequest;

class StoreRequest extends AbstractStoreRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'integer', 'min:1'],
        ];
    }
}

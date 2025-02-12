<?php

namespace App\Modules\Storefront\Cart\Interface\Http\Requests;

use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractUpdateRequest;

class UpdateRequest extends AbstractUpdateRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }
}

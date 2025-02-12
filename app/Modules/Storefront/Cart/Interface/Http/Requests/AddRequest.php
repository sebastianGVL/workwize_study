<?php

namespace App\Modules\Storefront\Cart\Interface\Http\Requests;

use App\Modules\Storefront\Cart\Domain\Http\Requests\AbstractAddRequest;

class AddRequest extends AbstractAddRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}

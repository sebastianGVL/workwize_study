<?php

namespace App\Modules\Storefront\Order\Interface\Http\Requests;

use App\Modules\Storefront\Order\Domain\Http\Requests\AbstractOrderStoreRequest;

class OrderStoreRequest extends AbstractOrderStoreRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'shipping_address' => ['required', 'string'],
            'billing_address' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
        ];
    }
}

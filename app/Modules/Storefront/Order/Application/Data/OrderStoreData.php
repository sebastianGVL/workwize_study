<?php

namespace App\Modules\Storefront\Order\Application\Data;

use App\Modules\Storefront\Order\Domain\Http\Requests\AbstractOrderStoreRequest;

readonly class OrderStoreData
{
    public function __construct(
        public string $payment_method,
        public string $billing_address,
        public string $shipping_address,
    )
    {
    }

    public static function fromRequest(AbstractOrderStoreRequest $request): self
    {
        return new self(
            payment_method: $request->string('payment_method'),
            billing_address: $request->string('billing_address'),
            shipping_address: $request->string('shipping_address'),
        );
    }
}

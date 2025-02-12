<?php

namespace App\Modules\Admin\Product\Application\Data;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractStoreRequest;

readonly class StoreData
{
    public function __construct(
        public string $name,
        public string $description,
        public int $stock,
        public float $price,
        public int $userId,
    )
    {
    }

    public static function fromRequest(AbstractStoreRequest $request, int $userId): self
    {
        return new self(
            name: $request->string('name'),
            description: $request->string('description'),
            stock: $request->integer('stock'),
            price: $request->float('price'),
            userId: $userId,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
            'userId' => $this->userId,
        ];
    }
}

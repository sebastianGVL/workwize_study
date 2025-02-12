<?php

namespace App\Modules\Admin\Product\Application\Data;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractUpdateRequest;

readonly class UpdateData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $stock,
        public float $price,
        public int $userId,
    )
    {
    }

    public static function fromRequest(AbstractUpdateRequest $request, int $userId, int $productId): self
    {
        return new self(
            id: $productId,
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
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
        ];
    }
}

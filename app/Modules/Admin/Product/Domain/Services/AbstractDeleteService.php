<?php

namespace App\Modules\Admin\Product\Domain\Services;


abstract class AbstractDeleteService
{
    public function delete(int $userId, int $productId): bool
    {
        $this->validate($userId, $productId);

        return $this->deleteProduct($productId);
    }
    abstract protected function validate(int $userId, int $productId): void;

    abstract protected function deleteProduct(int $productId): bool;
}

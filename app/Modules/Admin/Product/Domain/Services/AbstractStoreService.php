<?php

namespace App\Modules\Admin\Product\Domain\Services;

use App\Modules\Admin\Product\Application\Data\StoreData;
use App\Modules\Admin\Product\Domain\Models\Product;

abstract class AbstractStoreService
{
    public function store(StoreData $storeData)
    {
        $this->validate($storeData);

        return $this->create($storeData);
    }

    abstract protected function validate(StoreData $data): void;

    abstract protected function create(StoreData $data): Product;
}

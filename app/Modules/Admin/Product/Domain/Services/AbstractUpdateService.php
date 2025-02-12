<?php

namespace App\Modules\Admin\Product\Domain\Services;

use App\Modules\Admin\Product\Application\Data\UpdateData;
use App\Modules\Admin\Product\Domain\Models\Product;

abstract class AbstractUpdateService
{
    public function update(UpdateData $data): Product
    {
        $this->validate($data);

        return $this->updateModel($data);
    }

    abstract protected function validate(UpdateData $data): void;

    abstract protected function updateModel(UpdateData $data): Product;
}

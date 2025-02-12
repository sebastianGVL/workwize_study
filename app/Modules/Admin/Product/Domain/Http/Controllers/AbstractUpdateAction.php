<?php

namespace App\Modules\Admin\Product\Domain\Http\Controllers;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractUpdateRequest;
use App\Modules\Admin\Product\Domain\Services\AbstractUpdateService;
use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class AbstractUpdateAction extends Controller
{
    abstract public function __invoke(AbstractUpdateRequest $request, int $userId, int $productId, AbstractUpdateService $updateService): JsonResponse;
}

<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Domain\Http\Controllers;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractStoreRequest;
use App\Modules\Admin\Product\Domain\Services\AbstractStoreService;
use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class AbstractStoreAction extends Controller
{
    abstract public function __invoke(AbstractStoreRequest $request, int $userId, AbstractStoreService $storeService): JsonResponse;
}

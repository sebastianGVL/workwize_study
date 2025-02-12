<?php

namespace App\Modules\Admin\Product\Domain\Http\Controllers;

use App\Modules\Admin\Product\Domain\Services\ShowServiceInterface;
use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractShowAction extends Controller
{
    abstract public function __invoke(Request $request, int $userId, int $productId, ShowServiceInterface $storeService): JsonResponse;
}

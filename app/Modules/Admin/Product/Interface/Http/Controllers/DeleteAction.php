<?php

namespace App\Modules\Admin\Product\Interface\Http\Controllers;

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractDeleteAction;
use App\Modules\Admin\Product\Domain\Services\AbstractDeleteService;
use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DeleteAction extends AbstractDeleteAction
{

    public function __invoke(Request $request, int $userId, int $productId, AbstractDeleteService $deleteService): JsonResponse
    {
        try {
            $deleteService->delete($userId, $productId);
        } catch (Throwable $e) {
            Log::error(
                'DeleteAction::__invoke failed: ' . $e->getMessage(),
                ['userId' => $userId, 'productId' => $productId]
            );

            return response()->json(
                data: BaseApiResponseData::make(null, 'product not deleted'),
                status: Response::HTTP_BAD_REQUEST
            );
        }


        return response()->json(
            data: BaseApiResponseData::make(null, 'success'),
            status: Response::HTTP_NO_CONTENT
        );
    }
}

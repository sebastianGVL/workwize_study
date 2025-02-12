<?php

namespace App\Modules\Admin\Product\Interface\Http\Controllers;

use App\Modules\Admin\Product\Application\Data\UpdateData;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractUpdateAction;
use App\Modules\Admin\Product\Domain\Http\Requests\AbstractUpdateRequest;
use App\Modules\Admin\Product\Domain\Services\AbstractUpdateService;
use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateAction extends AbstractUpdateAction
{

    public function __invoke(AbstractUpdateRequest $request, int $userId, int $productId, AbstractUpdateService $updateService): JsonResponse
    {
        try {
            $product = $updateService->update(UpdateData::fromRequest($request, $userId, $productId));
        }catch (Throwable $e) {
            Log::error(
                'UpdateAction::__invoke failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'userId' => $userId]
            );

            return response()->json(
                data: BaseApiResponseData::make(null, 'product not updated'),
                status: Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'description' => $product->description,
                        'stock' => $product->stock,
                    ]
                ],
                'success'
            ),
            status: Response::HTTP_OK
        );
    }
}

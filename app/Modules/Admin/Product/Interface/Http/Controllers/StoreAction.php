<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Interface\Http\Controllers;

use App\Modules\Admin\Product\Application\Data\StoreData;
use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractStoreAction;
use App\Modules\Admin\Product\Domain\Http\Requests\AbstractStoreRequest;
use App\Modules\Admin\Product\Domain\Services\AbstractStoreService;
use App\Modules\Admin\User\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class StoreAction extends AbstractStoreAction
{
    public function __invoke(AbstractStoreRequest $request, int $userId, AbstractStoreService $storeService): JsonResponse
    {
        try {
            $product = $storeService->store(StoreData::fromRequest($request, $userId));
        } catch (Throwable $e) {
            Log::error(
                'StoreAction::__invoke failed: ' . $e->getMessage(),
                ['product' => $request->toArray(), 'userId' => $userId]
            );

            return response()->json(
                data: BaseApiResponseData::make(null, 'product not saved'),
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
            status: Response::HTTP_CREATED
        );
    }
}

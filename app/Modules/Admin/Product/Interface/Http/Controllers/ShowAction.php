<?php

namespace App\Modules\Admin\Product\Interface\Http\Controllers;

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractShowAction;
use App\Modules\Admin\Product\Domain\Services\ShowServiceInterface;
use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowAction extends AbstractShowAction
{
    public function __invoke(Request $request, int $userId, int $productId, ShowServiceInterface $storeService): JsonResponse
    {
        try {
            $product = $storeService->show($productId);
        } catch (ModelNotFoundException) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'not found'),
                status: Response::HTTP_NOT_FOUND
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

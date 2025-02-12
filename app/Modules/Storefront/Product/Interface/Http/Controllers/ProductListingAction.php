<?php

namespace App\Modules\Storefront\Product\Interface\Http\Controllers;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use App\Modules\Storefront\Product\Domain\Http\Controllers\AbstractProductListingAction;
use App\Modules\Storefront\Product\Domain\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductListingAction extends AbstractProductListingAction
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'products' => Product::query()->paginate('1'),
                ],
                'success'
            ),
            status: Response::HTTP_OK
        );
    }
}

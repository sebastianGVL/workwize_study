<?php

namespace App\Modules\Admin\Product\Interface\Http\Controllers;

use App\Modules\Admin\Product\Domain\Http\Controllers\AbstractIndexAction;
use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IndexAction extends AbstractIndexAction
{
    public function __invoke(): JsonResponse
    {
        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'products' => Product::query()->where('user_id', Auth::id())->paginate(10)
                ],
                'success'
            ),
            status: Response::HTTP_OK
        );
    }
}

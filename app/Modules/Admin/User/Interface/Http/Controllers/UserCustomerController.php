<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Interface\Http\Controllers;

use App\Modules\Admin\Customer\Domain\Models\Customer;
use App\Modules\Admin\User\Domain\Http\Controllers\AbstractUserCustomerController;
use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCustomerController extends AbstractUserCustomerController
{
    public function index(string $userId): JsonResponse
    {
        $customers = Customer::query()
            ->whereHas('orders.items.product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->distinct()
            ->get();

        return response()->json(
            data: BaseApiResponseData::make(
                [
                    'customers' => $customers,
                ],
                'success'
            ),
            status: Response::HTTP_OK
        );
    }
}

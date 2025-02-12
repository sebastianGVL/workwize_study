<?php

namespace App\Modules\Storefront\Customer\Interface\Http\Middleware;

use App\Modules\Common\Interface\Http\Data\BaseApiResponseData;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(
                data: BaseApiResponseData::make(null, 'Unauthenticated.'),
                status:Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}

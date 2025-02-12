<?php

namespace App\Modules\Storefront\Product\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractProductListingAction extends Controller
{
    abstract public function __invoke(Request $request): JsonResponse;
}

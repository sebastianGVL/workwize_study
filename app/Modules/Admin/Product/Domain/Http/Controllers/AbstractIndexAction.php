<?php

namespace App\Modules\Admin\Product\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class AbstractIndexAction extends Controller
{
    abstract public function __invoke(): JsonResponse;
}

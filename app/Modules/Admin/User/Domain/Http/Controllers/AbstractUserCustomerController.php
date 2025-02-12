<?php

namespace App\Modules\Admin\User\Domain\Http\Controllers;

use App\Modules\Common\Interface\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class AbstractUserCustomerController extends Controller
{
    abstract public function index(string $userId): JsonResponse;
}

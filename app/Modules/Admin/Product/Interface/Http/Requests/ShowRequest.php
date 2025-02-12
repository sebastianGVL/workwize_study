<?php

namespace App\Modules\Admin\Product\Interface\Http\Requests;

use App\Modules\Admin\Product\Domain\Http\Requests\AbstractShowRequest;

class ShowRequest extends AbstractShowRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}

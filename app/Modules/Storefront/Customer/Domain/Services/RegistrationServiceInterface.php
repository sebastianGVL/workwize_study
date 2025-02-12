<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Domain\Services;


use App\Modules\Storefront\Customer\Application\Data\RegistrationData;
use App\Modules\Storefront\Customer\Domain\Models\Customer;

interface RegistrationServiceInterface
{
    public function register(RegistrationData $data): Customer;
}

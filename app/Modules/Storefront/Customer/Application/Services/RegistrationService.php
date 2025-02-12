<?php

declare(strict_types=1);

namespace App\Modules\Storefront\Customer\Application\Services;

use App\Modules\Storefront\Customer\Application\Data\RegistrationData;
use App\Modules\Storefront\Customer\Domain\Models\Customer;
use App\Modules\Storefront\Customer\Domain\Services\RegistrationServiceInterface;
use Illuminate\Support\Facades\Hash;

class RegistrationService implements RegistrationServiceInterface
{
    public function register(RegistrationData $data): Customer
    {
        $customer = new Customer();

        $customer->name = $data->name;
        $customer->email = $data->email;
        $customer->password = Hash::make($data->password);

        $customer->save();

        return $customer;
    }
}

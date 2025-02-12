<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Application\Services;

use App\Modules\Admin\User\Application\Data\RegistrationData;
use App\Modules\Admin\User\Domain\Models\User;
use App\Modules\Admin\User\Domain\Services\RegistrationServiceInterface;

class RegistrationService implements RegistrationServiceInterface
{
    public function register(RegistrationData $data): User
    {
        $user = new User();

        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;

        $user->save();
        
        return $user;
    }
}

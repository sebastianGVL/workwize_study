<?php

declare(strict_types=1);

namespace App\Modules\Admin\User\Domain\Services;

use App\Modules\Admin\User\Application\Data\RegistrationData;
use App\Modules\Admin\User\Domain\Models\User;

interface RegistrationServiceInterface
{
    public function register(RegistrationData $data): User;
}

<?php

namespace Tests\Unit\Admin;

use App\Modules\Admin\User\Application\Data\RegistrationData;
use App\Modules\Admin\User\Application\Services\RegistrationService;
use App\Modules\Admin\User\Domain\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationServiceTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * A basic test example.
     */
    public function test_that_register_is_success(): void
    {
        $registrationService = resolve(RegistrationService::class);
        $data = new RegistrationData(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password
        );

        $user = $registrationService->register($data);

        $this->assertTrue($user instanceof User);
        $this->assertTrue($user->name === $data->name);
        $this->assertIsInt($user->id);
    }
}

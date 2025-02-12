<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function test_the_application_returns_a_validation_response(): void
    {
        $response = $this->post(
            route('api.v1.admin.auth.register'),
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $this->faker->password,
                'password_confirmation' => $this->faker->password,
            ],
            ['Accept' => 'application/json']
        );

        $this->assertStringContainsString("The password field confirmation does not match", $response->content());
    }

    public function test_the_application_returns_a_success_response(): void
    {
        $password = $this->faker->password;
        $response = $this->post(
            route('api.v1.admin.auth.register'),
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $password,
                'password_confirmation' => $password,
            ],
            ['Accept' => 'application/json']
        );

        $this->assertStringContainsString("success", $response->content());
    }
}

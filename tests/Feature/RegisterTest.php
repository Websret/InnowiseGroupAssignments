<?php

namespace Tests\Feature;

use Database\Seeders\UserTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Tests\TestCase;

class RegisterTest extends TestCase
{
//    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration_with_headers()
    {
//        $this->artisan('migrate:refresh');
//        $this->seed(UserTypes::class);
        $password = fake()->password;
        $response = $this->post(route('register.store'), [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertAuthenticated();
    }
}

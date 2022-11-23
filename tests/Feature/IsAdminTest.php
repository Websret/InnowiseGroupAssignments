<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IsAdminTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_is_admin_and_view_admin_dashboard()
    {
        $this->seed(UserTypes::class);
        $user = User::factory()->create(['type_id' => 2]);

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $this->artisan('migrate:refresh');
    }
}

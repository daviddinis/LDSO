<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testAppAccess_ShouldGive200()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testBasicLogin_ShouldRedirectToLogin()
    {
        $response = $this->get('/car')->assertRedirect('login');
    }

    public function testBasicLogin_ShouldRedirectToDashboard()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/car');
    }
}

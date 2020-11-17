<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginAccess_ShouldGive200()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testBasicLogin_ShouldLoginSuccesfully()
    {

        // TODO implement
        $this->assertTrue(true);
    }
}

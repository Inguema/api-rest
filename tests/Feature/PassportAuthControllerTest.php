<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PassportAuthControllerTest extends TestCase
{
    public function test_register()
    {
        $response = $this->post(route('api.register'), [
            'name' => 'JMac',
            'email' => 'jmac@example.com',
            'password' => '1234568999',
        ]);

        /*
        $a = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => null,
        ]*/

        print_r($response->getContent());
        print_r($response->getStatusCode());

        $response->assertStatus($response->getStatusCode());
    }

    public function test_login()
    {
        $response = $this->post(route('api.login'), [
            'email' => 'admin@prueba.es',
            'password' => 'admin123'
        ]);

        $response->assertJsonStructure([
            'token'
        ]);

        $response->assertStatus($response->getStatusCode());
    }
}

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
            'name' => 'JMacana',
            'email' => 'jmacana@example.com',
            'password' => '1234Admin!'
        ]);

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

    public function test_logout()
    {
        $response = $this->post(route('api.login'), [
            'email' => 'admin@prueba.es',
            'password' => 'admin123'
        ]);

        $headers = [
            'Authorization' => 'Bearer '. $response->json('token'),
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($headers)->get('/api/logout');
        $response->assertStatus($response->getStatusCode());
    }
}

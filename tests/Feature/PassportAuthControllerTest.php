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
            'password' => '1234568999',
        ]);

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

    public function test_logout()
    {

    }
}

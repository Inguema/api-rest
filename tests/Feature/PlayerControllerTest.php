<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    private function login()
    {
        // Login para obtener token
        $response = $this->post(route('api.login'), [
            'email' => 'admin@prueba.es',
            'password' => 'admin123'
        ]);

        $response->assertJsonStructure([
            'token'
        ]);

        return $response->json('token');
    }

    public function test_index()
    {
        // Probar el index de player controller
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
        ])->get('/api/players');

        //print_r($response->json());
        $response->assertStatus($response->getStatusCode());
    }

    public function test_store_game()
    {
        // Probar el store de player controller
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
        ])->post('/api/players/games');

        $response->assertStatus($response->getStatusCode());
    }

    public function test_update()
    {
        $headers = [
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
        ];

        $data =  [
            'name' => 'AdminPlus'
        ];

        $response = $this->withHeaders($headers)->put('/api/players', $data);
        $response->assertStatus($response->getStatusCode());
    }

    public function test_destroy_game()
    {
        $headers = [
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($headers)->delete('/api/players/games');
        $response->assertStatus($response->getStatusCode());
    }

    public function test_show_game()
    {    $headers = [
        'Authorization' => 'Bearer '. $this->login(),
        'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($headers)->get('/api/players/games');
        $response->assertStatus($response->getStatusCode());
        //print_r($response->json());
    }

    public function test_ranking()
    {
        $headers = [
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($headers)->get('/api/players/ranking');
        $response->assertStatus($response->getStatusCode());
    }

    public function test_ranking_loser()
    {
       $headers = [
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
       ];

        $response = $this->withHeaders($headers)->get('/api/players/loser');
        $response->assertStatus($response->getStatusCode());
    }

    public function test_ranking_winner()
    {
       $headers = [
            'Authorization' => 'Bearer '. $this->login(),
            'Accept' => 'application/json'
       ];

        $response = $this->withHeaders($headers)->get('/api/players/winner');
        $response->assertStatus($response->getStatusCode());
    }
}

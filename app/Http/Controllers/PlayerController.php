<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Game;

class PlayerController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function storeGame(Request $request)
    {
        $game = new Game();
        $game->dice_one = rand(1,6);
        $game->dice_two = rand(1,6);
        $game->user_id = $request->user()->id;
        $game->result = false;

        $result = $game->dice_one + $game->dice_two;

        if ($result === 7) {
            $game->result = true;
        }

        $game->save();

        return $game;
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $user->name = $request->request->get('name');
        $user->save();

        return $user;
    }

    public function destroyGame(Request $request)
    {
        $user = $request->user();
        $game = new Game();
        $game->deleteByUser($user);
        return ['success' => true];
    }

    public function showGame(Request $request)
    {
        $user = $request->user();
        $game = new Game();
        return $game->getByUser($user);
    }

    public function ranking()
    {

    }

    public function rankingLoser()
    {

    }

    public function rankingWinner(): array
    {
        $game = new Game();
        $winners = $game->countWinners();

        $maxPorcentaje = 0;
        $porcentajes = [];
        $result = [];

        // Obtenemos todos los ganadores
        foreach ($winners as $winner) {
            $userId = $winner->user_id;
            $totalUserWins = $winner->total;

            $totalPartidasUser = $game->getByUserId($userId)->count();

            // Calculamos sus porcentajes
            $porcentajes[] = [
                'userId' => $userId,
                'porcentajeVictorias' => round(($totalUserWins / $totalPartidasUser) * 100, 2),
                'totalPartidasUser' => $totalPartidasUser,
                'totalPartidasGanadas' => $totalUserWins,
            ];
        }

        // Buscamos el porcentaje mas alto
        foreach ($porcentajes as $key => $porcentaje) {
            if ($key === 0) {
                $maxPorcentaje = $porcentaje['porcentajeVictorias'];
            } else {
                if ($maxPorcentaje < $porcentaje['porcentajeVictorias']) {
                    $maxPorcentaje = $porcentaje['porcentajeVictorias'];
                }
            }
        }

        // Nos guardamos solo los que coincidan con el mas alto para el resultado
        foreach ($porcentajes as $porcentaje) {
            if ($maxPorcentaje === $porcentaje['porcentajeVictorias']) {
               $result[] = $porcentaje;
            }
        }

        return $result;
    }
}

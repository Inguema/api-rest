<?php

namespace App\Http\Controllers;

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
        $game = new Game();
        $totalGames = $game::count();
        $totalWins = $game->countWin()->count();

        return [
            'totalWins' => $totalWins,
            'totalGames' => $totalGames,
            'porcentajeMedioLogros' => round(($totalWins / $totalGames) * 100, 2)
        ];

    }

    public function rankingLoser(): array
    {
        $game = new Game();
        $losers = $game->countLosers();

        return $this->_calcularPorcentajes($losers);
    }

    public function rankingWinner(): array
    {
        $game = new Game();
        $winners = $game->countWinners();

        return $this->_calcularPorcentajes($winners);
    }

    private function _calcularPorcentajes($items)
    {
        $game = new Game();
        $result = [];

        $porcentajes = [];
        $maxPorcentaje = 0;

        // Obtenemos todos los ganadores
        foreach ($items as $item) {
            $userId = $item->user_id;
            $totalUser = $item->total;

            $totalPartidasUser = $game->getByUserId($userId)->count();

            // Calculamos sus porcentajes
            // porcentajeEstado = Porcentaje de partidas perdidas o ganadas respecto al total de jugadas por un jugador
            // totalPartidasEstado = Estado de la partida: Winns or Lost
            // totalPartidasUser = Total de partidas de un jugador
            $porcentajes[] = [
                'userId' => $userId,
                'porcentajeEstado' => round(($totalUser / $totalPartidasUser) * 100, 2),
                'totalPartidasEstado' => $totalUser,
                'totalPartidasUser' => $totalPartidasUser,
            ];
        }

        // Buscamos el porcentaje mas alto
        foreach ($porcentajes as $key => $porcentaje) {
            if ($key === 0) {
                $maxPorcentaje = $porcentaje['porcentajeEstado'];
            } else {
                if ($maxPorcentaje < $porcentaje['porcentajeEstado']) {
                    $maxPorcentaje = $porcentaje['porcentajeEstado'];
                }
            }
        }

        // Nos guardamos solo los que coincidan con el más alto para el resultado
        foreach ($porcentajes as $porcentaje) {
            if ($maxPorcentaje === $porcentaje['porcentajeEstado']) {
                $result[] = $porcentaje;
            }
        }
        return $result;
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class GameFactory extends Factory
{
    public function definition()
    {
        $diceOne = $this->faker->numberBetween(1, 6);
        $diceTwo = $this->faker->numberBetween(1, 6);
        $result = false;

        if ($diceOne + $diceTwo === 7) {
            $result = true;
        }

        return [
            'user_id'   => User::all()->random()->id,
            'dice_one'  => $diceOne,
            'dice_two'  => $diceTwo,
            'result'    => $result,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dice_one',
        'dice_two',
    ];

    // Relación uno a muchos inversa
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function deleteByUser(User $user)
    {
        $this->where('user_id', '=', $user->id)->delete();

        // DELETE FROM `games` WHERE `games`.`user_id` = 2 (Ejemplo delete en bbdd)
    }

    public function getByUser(User $user)
    {
        return $this->where('user_id', '=', $user->id)->get();
    }

    public function getByUserId(int $userId)
    {
        return $this->where('user_id', '=', $userId)->get();
    }

    public function countWinners()
    {
        return $this->select('user_id', $this->raw('count(*) AS total'))
            ->where('result', '=', true)
            ->groupBy('user_id')
            ->get();

        // SELECT COUNT(*) AS total, user_id FROM games WHERE result=1 GROUP BY user_id
    }

    public function countLosers()
    {
        return $this->select('user_id', $this->raw('count(*) AS total'))
            ->where('result', '=', false)
            ->groupBy('user_id')
            ->get();
    }

    public function countWin()
    {
        return $this->select('id', $this->raw('count(*) AS total'))
            ->where('result', '=', true)
            ->groupBy('id')
            ->get();

        // SELECT COUNT(*) AS total, user_id FROM games WHERE result=1 GROUP BY user_id
    }

}

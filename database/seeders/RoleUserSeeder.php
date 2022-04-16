<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = Role::findByName('user');
        $users = User::all();

        foreach ($users as $user) {
            if (!$user->hasRole('admin')) {
                $user->roles()->attach($roleUser);
            }
        }
    }
}

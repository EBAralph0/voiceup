<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => bcrypt('user123'),
            'proprietaire' => true, // L'utilisateur est propriétaire
        ]);

        User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('user123'),
            'proprietaire' => false, // L'utilisateur n'est pas propriétaire
        ]);
    }
}

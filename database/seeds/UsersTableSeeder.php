<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Haidar Aziz H',
            'identity_id' => '3519032701140003',
            'gender' => 1,
            'address' => 'Jl. Panjaitan Nglandung Geger Madiun',
            'photo' => null,
            'phone_number' => '082228830579',
            'email' => 'haidaraziz@gmail.com',
            'password' => app('hash')->make('aZiZ#000'),
            'api_token' => Str::random(32),
            'role' => 1,
            'status' => 1
        ]);
    }
}

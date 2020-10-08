<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name'=>'Andrea Manzaba',
            'username'=>'andrea',
            'password'=>Hash::make('123')
        ]);
        User::create([
            'name'=>'Mario Moreno',
            'username'=>'mario',
            'password'=>Hash::make('123')
        ]);
    }
}

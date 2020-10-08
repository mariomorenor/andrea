<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'name'=>'usuario',
            'last_name'=>'final',
            'cedula'=>1111111111,
            'address'=>'-',
            'phone'=>1111111111
        ]);
    }
}

<?php

use App\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'type'=>'efectivo'
        ]);
        PaymentMethod::create([
            'type'=>'promoción'
        ]);
        PaymentMethod::create([
            'type'=>'crédito'
        ]);
    }
}

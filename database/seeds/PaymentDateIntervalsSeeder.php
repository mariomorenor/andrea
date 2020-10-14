<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentDateIntervalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_date_intervals')->insert([
            'interval'=>'Semanal'
        ]);
        DB::table('payment_date_intervals')->insert([
            'interval'=>'Quincenal'
        ]);
        DB::table('payment_date_intervals')->insert([
            'interval'=>'Mensual'
        ]);
    }
}

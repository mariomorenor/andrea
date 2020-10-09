<?php

use App\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 6 ; $i++) { 
            for ($j=1; $j < 4 ; $j++) { 
                Price::create([
                    'product_id'=>$i,
                    'payment_method'=>$j,
                    'value'=>rand(10,999)/10
                ]);
            }
        }
    }
}

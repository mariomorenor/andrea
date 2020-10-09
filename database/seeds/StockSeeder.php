<?php

use App\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 6; $i++) { 
           $stock =  Stock::find($i);
            $stock->update([
                'total'=>rand(10,100)
            ]);
        }
    }
}

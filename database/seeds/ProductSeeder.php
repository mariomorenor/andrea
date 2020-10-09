<?php

use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'=>'Producto 1',
            'code'=>'PR-001',
            'price'=>rand(10,999)/10,
            'description'=>Str::random(150),
        ]);
        Product::create([
            'name'=>'Producto 2',
            'code'=>'PR-002',
            'price'=>rand(10,999)/10,
            'description'=>Str::random(150),
        ]);
        Product::create([
            'name'=>'Producto 3',
            'code'=>'PR-003',
            'price'=>rand(10,999)/10,
            'description'=>Str::random(150),
        ]);
        Product::create([
            'name'=>'Producto 4',
            'code'=>'PR-004',
            'price'=>rand(10,999)/10,
            'description'=>Str::random(150),
        ]);
        Product::create([
            'name'=>'Producto 5',
            'code'=>'PR-005',
            'price'=>rand(10,999)/10,
            'description'=>Str::random(150),
        ]);
    }
}

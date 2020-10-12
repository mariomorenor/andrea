<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Observers\StockEntryObserver;
use App\Observers\StockObserver;
use App\Observers\StockRegistryObserver;
use App\Product;
use App\StockEntry;
use App\StockRegistry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        StockRegistry::observe(StockRegistryObserver::class);
    }
}

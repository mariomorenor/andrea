<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Observers\StockEntryObserver;
use App\Observers\StockObserver;
use App\Product;
use App\StockEntry;
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
        StockEntry::observe(StockEntryObserver::class);
    }
}

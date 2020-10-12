<?php

namespace App\Observers;

use App\Stock;
use App\StockRegistry;

class StockRegistryObserver
{
    /**
     * Handle the stock entry "created" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function created(StockRegistry $stockRegistry)
    {   
        $stock = Stock::find($stockRegistry->product_id);
        $total = $stock->total == null?0:$stock->total;
        $stock->update([
            'total'=> $total + $stockRegistry->quantity 
        ]);
    }

    /**
     * Handle the stock entry "updated" event.
     *
     * @param  \App\StockRegistry  $stockEntry
     * @return void
     */
    public function updated(StockRegistry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "deleted" event.
     *
     * @param  \App\StockRegistry  $stockEntry
     * @return void
     */
    public function deleted(StockRegistry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "restored" event.
     *
     * @param  \App\StockRegistry  $stockEntry
     * @return void
     */
    public function restored(StockRegistry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "force deleted" event.
     *
     * @param  \App\StockRegistry  $stockEntry
     * @return void
     */
    public function forceDeleted(StockRegistry $stockEntry)
    {
        //
    }
}

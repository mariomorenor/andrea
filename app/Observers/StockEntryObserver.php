<?php

namespace App\Observers;

use App\Stock;
use App\StockEntry;

class StockEntryObserver
{
    /**
     * Handle the stock entry "created" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function created(StockEntry $stockEntry)
    {   
        $stock = Stock::find($stockEntry->product_id);
        $total = $stock->total == null?0:$stock->total;
        $stock->update([
            'total'=> $total + $stockEntry->quantity 
        ]);
    }

    /**
     * Handle the stock entry "updated" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function updated(StockEntry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "deleted" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function deleted(StockEntry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "restored" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function restored(StockEntry $stockEntry)
    {
        //
    }

    /**
     * Handle the stock entry "force deleted" event.
     *
     * @param  \App\StockEntry  $stockEntry
     * @return void
     */
    public function forceDeleted(StockEntry $stockEntry)
    {
        //
    }
}

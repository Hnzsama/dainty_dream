<?php

namespace App\Observers;

use App\Models\IncomingTransaction;

class IncomingTransactionObserver
{
    /**
     * Handle the IncomingTransaction "created" event.
     */
    public function created(IncomingTransaction $incoming): void
    {
        // Increase product stock by the incoming quantity
        $incoming->product->increment('stock', $incoming->quantity);
    }

    /**
     * Handle the IncomingTransaction "updated" event.
     */
    public function updated(IncomingTransaction $incoming): void
    {
        // If quantity changed, adjust product stock
        $oldQuantity = $incoming->getOriginal('quantity');
        $newQuantity = $incoming->quantity;
        
        if ($oldQuantity != $newQuantity) {
            $difference = $newQuantity - $oldQuantity;
            $incoming->product->increment('stock', $difference);
        }
    }

    /**
     * Handle the IncomingTransaction "deleted" event.
     */
    public function deleted(IncomingTransaction $incoming): void
    {
        // Decrease product stock by the incoming quantity
        $incoming->product->decrement('stock', $incoming->quantity);
    }

    /**
     * Handle the IncomingTransaction "restored" event.
     */
    public function restored(IncomingTransaction $incoming): void
    {
        // Re-add stock when transaction is restored
        $incoming->product->increment('stock', $incoming->quantity);
    }

    /**
     * Handle the IncomingTransaction "force deleted" event.
     */
    public function forceDeleted(IncomingTransaction $incoming): void
    {
        // Decrease stock on force delete
        $incoming->product->decrement('stock', $incoming->quantity);
    }
}

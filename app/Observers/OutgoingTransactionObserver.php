<?php

namespace App\Observers;

use App\Models\OutgoingTransaction;

class OutgoingTransactionObserver
{
    /**
     * Handle the OutgoingTransaction "created" event.
     */
    public function created(OutgoingTransaction $outgoing): void
    {
        // Decrease product stock by the outgoing quantity
        $outgoing->product->decrement('stock', $outgoing->quantity);
    }

    /**
     * Handle the OutgoingTransaction "updated" event.
     */
    public function updated(OutgoingTransaction $outgoing): void
    {
        // If quantity changed, adjust product stock
        $oldQuantity = $outgoing->getOriginal('quantity');
        $newQuantity = $outgoing->quantity;
        
        if ($oldQuantity != $newQuantity) {
            $difference = $oldQuantity - $newQuantity; // Reverse the logic for outgoing
            $outgoing->product->increment('stock', $difference);
        }
    }

    /**
     * Handle the OutgoingTransaction "deleted" event.
     */
    public function deleted(OutgoingTransaction $outgoing): void
    {
        // Re-add product stock when transaction is deleted
        $outgoing->product->increment('stock', $outgoing->quantity);
    }

    /**
     * Handle the OutgoingTransaction "restored" event.
     */
    public function restored(OutgoingTransaction $outgoing): void
    {
        // Decrease stock again when transaction is restored
        $outgoing->product->decrement('stock', $outgoing->quantity);
    }

    /**
     * Handle the OutgoingTransaction "force deleted" event.
     */
    public function forceDeleted(OutgoingTransaction $outgoing): void
    {
        // Re-add stock on force delete
        $outgoing->product->increment('stock', $outgoing->quantity);
    }
}

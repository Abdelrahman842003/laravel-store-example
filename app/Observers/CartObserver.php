<?php

namespace App\Observers;

use App\Models\Cart;
use Illuminate\Support\Str;

//Events
//Creating: before a record has been created.
//Created: after a record has been created.
//Saving: before a record is saved.
//Saved: after a record has been saved.
//Updating: before a record is updated.
//Updated: after a record has been updated.
//Deleting: before a record is deleted or soft-deleted.
//Deleted: after a record has been deleted or soft-deleted.
//Restoring: before a soft-deleted record is going to be restored.
//Restored: after a soft-deleted record has been restored.
//Retrieved: after a record has been retrieved.
class CartObserver
{
    /**
     * Handle the Cart "creating" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function creating(Cart $cart)
    {
            $cart->id = Str::uuid();
            $cart->cookie_id = $cart->getCookieId();
    }

    /**
     * Handle the Cart "updated" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function updated(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function deleted(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "restored" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function restored(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "force deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function forceDeleted(Cart $cart)
    {
        //
    }
}

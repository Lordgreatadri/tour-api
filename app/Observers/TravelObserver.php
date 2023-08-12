<?php

namespace App\Observers;

use App\Models\Travel;

class TravelObserver
{
    /** You must register in the EVentsServiceProvider for it to work
     * Handle the Travel "created" event.
     */
    public function creating(Travel $travel): void
    {
        $travel->slug = str($travel->name)->slug();
    }
}

<?php

namespace App\Observers;

use App\Events\DonationApproved;
use App\Events\DonationRejected;
use App\Models\Donation;

class DonationObserver
{
    /**
     * Handle the Donation "created" event.
     *
     * @param  \App\Models\Donation  $donation
     * @return void
     */
    public function created(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "updated" event.
     *
     * @param  \App\Models\Donation  $donation
     * @return void
     */
    public function updated(Donation $donation)
    {
        if (!$donation->isDirty()) {
            return;
        }
        if ($donation->status === 'approved') {
            DonationApproved::dispatch($donation);
        } else {
            DonationRejected::dispatch($donation);
        }
    }

    /**
     * Handle the Donation "deleted" event.
     *
     * @param  \App\Models\Donation  $donation
     * @return void
     */
    public function deleted(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "restored" event.
     *
     * @param  \App\Models\Donation  $donation
     * @return void
     */
    public function restored(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "force deleted" event.
     *
     * @param  \App\Models\Donation  $donation
     * @return void
     */
    public function forceDeleted(Donation $donation)
    {
        //
    }
}

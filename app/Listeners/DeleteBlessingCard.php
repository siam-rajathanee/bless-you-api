<?php

namespace App\Listeners;

use App\Events\DonationRejected;
use Storage;

class DeleteBlessingCard
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DonationRejected  $event
     * @return void
     */
    public function handle(DonationRejected $event)
    {
        $blessing_card = $event->getDonation() ? $event->getDonation()->blessingCard : null;

        if ($blessing_card) {
            Storage::disk('public')->delete($blessing_card->card);
            $blessing_card->delete();
        }
    }
}

<?php

namespace App\Providers;

use App\Events\DonationApproved;
use App\Events\DonationRejected;
use App\Listeners\CreateBlessingCard;
use App\Listeners\DeleteBlessingCard;
use App\Models\Donation;
use App\Observers\DonationObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DonationApproved::class => [
            CreateBlessingCard::class,
        ],
        DonationRejected::class => [
            DeleteBlessingCard::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Donation::observe(DonationObserver::class);
    }
}

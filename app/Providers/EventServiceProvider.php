<?php

namespace App\Providers;

// use App\Models\Travel;
// use App\Observers\TravelObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];


    // protected $obsservers = [
    //     Travel::class => [TravelObserver::class],
    //     //ADD other observers here as well o KD
    // ];


    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //Travel::observe(TravelObserver::class);//you can also configure it in your own ... as athe above
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

<?php

namespace App\Providers;

use App\EventSourcing\Listeners\UserSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register the subscriber
     * @var array
     */
    protected $subscribe = [
        UserSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * As we're not using the Laravel folder convention for events we need to tell the application where the events are
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            $this->app->path('EventSourcing'),
        ];
    }
}

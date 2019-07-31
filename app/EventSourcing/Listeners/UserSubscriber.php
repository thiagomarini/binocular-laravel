<?php

namespace App\EventSourcing\Listeners;

use App\EventSourcing\Projections\User\Actions;
use App\UserActions;
use Binocular\Events\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class UserSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var Actions
     */
    private $merchantStatus;

    public function __construct(Actions $merchantStatus)
    {
        $this->merchantStatus = $merchantStatus;
    }

    /**
     * Best place to use the projection to calculate state
     * @param Event $event
     */
    public function handle(Event $event)
    {
        Log::info('Event listener called', [
            'event' => json_encode($event)
        ]);

        try {
            /**
             * Use the projection to calculate state
             */
            $newState = $this->merchantStatus->calculateState($event->getRootId());

            $status = UserActions::firstOrNew([
                'root_id' => $event->getRootId(),
            ]);

            /**
             * Save the new state
             */
            $status->payload = json_encode($newState);
            $status->save();

            Log::info('Read model saved', [
                'action'    => __METHOD__,
                'new_state' => $newState,
                'user_id'   => $event->getRootId(),
            ]);
        } catch (\Exception $e) {
            Log::error('Fail to save read model', [
                'action'  => __METHOD__,
                'error'   => $e->getMessage(),
                'user_id' => $event->getRootId(),
            ]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            [
                'App\EventSourcing\Events\Merchant\LoggedIn',
                'App\EventSourcing\Events\Merchant\SignedUp',
            ],
            'App\EventSourcing\Listeners\UserListener@handle'
        );
    }
}

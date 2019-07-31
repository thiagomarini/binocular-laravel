<?php

namespace App\EventSourcing\Repositories;

use App\EventSourcing\Events\User\LoggedIn;
use App\EventSourcing\Events\User\SignedUp;
use Binocular\Events\Event;
use Binocular\Events\EventRepository;

class Factory
{
    /**
     * @param Event $event
     *
     * @return EventRepository
     */
    public static function create(Event $event): EventRepository
    {
        if ($event instanceof SignedUp
            || $event instanceof LoggedIn) {
            return resolve(UserEventRepository::class);
        }

        throw new \InvalidArgumentException(sprintf('No repository is mapped to event: %s', get_class($event)));
    }
}

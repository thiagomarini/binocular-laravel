<?php

namespace App\EventSourcing\Repositories;

use App\UserEvent;
use Binocular\Events\Event;
use Binocular\Events\EventRepository;

class UserEventRepository implements EventRepository
{
    /**
     * @param Event $event
     */
    public function store(Event $event)
    {
        $eloquentEvent = new UserEvent;
        $eloquentEvent->root_id = $event->getRootId();
        $eloquentEvent->serialised = serialize($event);
        $eloquentEvent->projection_snapshot = $event->getSnapshotProjectionName();
        $eloquentEvent->save();
    }

    /**
     * @param $rootId
     * @param \DateTime|null $from
     *
     * @return array
     */
    public function all($rootId, \DateTime $from = null): array
    {
        $query = UserEvent::where('root_id', $rootId);

        if ($from) {
            $query->where('created_at', '>=', $from->format(config('weengs.simple_date')));
        }

        $query->orderBy('created_at', 'ASC');

        $events = [];

        foreach ($query->get() as $row) {
            $events[] = unserialize($row->serialised);
        }

        return $events;
    }

    /**
     * @param $rootId
     * @param string $snapshotProjectionName
     * @param \DateTime $from
     *
     * @return Event|null
     * @throws \Exception
     */
    public function getFirstSnapshotAfter($rootId, string $snapshotProjectionName, \DateTime $from): ?Event
    {
        throw new \Exception('not implemented yet');
    }
}

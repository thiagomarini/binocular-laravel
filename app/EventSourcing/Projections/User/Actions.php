<?php

namespace App\EventSourcing\Projections\User;

use Binocular\Projections\BaseProjection;
use App\EventSourcing\Repositories\UserEventRepository;
use Binocular\Events\Event;
use App\Exceptions\BusinessException;

class Actions extends BaseProjection
{
    /**
     * MerchantListener constructor.
     *
     * @param UserEventRepository $repository
     */
    public function __construct(UserEventRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getName(): string
    {
        return 'merchant_status_projection';
    }

    public function getReducers(): array
    {
        return [
            'user_signed_up' => [
                1 => function (array $currentState, Event $event): ?array {
                    return ['signed_up_at' => $event->getCreatedAt()];
                }
            ],
            'user_logged_in' => [
                1 => function (array $currentState, Event $event): ?array {

                    $currentState['last_logged_in_at'] = $event->getCreatedAt();

                    return $currentState;
                }
            ],
        ];
    }
}

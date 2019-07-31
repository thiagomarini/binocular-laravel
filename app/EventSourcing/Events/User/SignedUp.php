<?php

namespace App\EventSourcing\Events\User;

use Binocular\Events\Action;
use Binocular\Events\BaseEvent;

class SignedUp extends BaseEvent
{
    protected function loadActions()
    {
        $this->actions = [
            new Action('user_signed_up', 1),
        ];
    }
}

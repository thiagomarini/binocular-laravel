<?php

namespace App\EventSourcing\Events\User;

use Binocular\Events\Action;
use Binocular\Events\BaseEvent;

class LoggedIn extends BaseEvent
{
    protected function loadActions()
    {
        $this->actions = [
            new Action('user_logged_in', 1),
        ];
    }
}

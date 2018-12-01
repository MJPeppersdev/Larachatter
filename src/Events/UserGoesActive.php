<?php

namespace Launcher\Larachatter\Events;

use Illuminate\Queue\SerializesModels;

class UserGoesActive
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}

<?php

namespace Launcher\Larachatter;

trait EventMap
{
    protected $events = [
        Events\MessageSent::class => [
        ],
    ];
}

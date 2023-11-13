<?php

namespace App\Listeners;

use Symfony\Contracts\EventDispatcher\Event;

class MyFirstListener
{
    public function onDemoEvent(Event $event): void
    {
        // fetch event information here
        echo "DemoListener is called!\n";
        echo "The value of the foo is: ".$event->getFoo()."\n";
    }
}
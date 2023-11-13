<?php

namespace App\Subsribers;

use App\Events\MyFirstEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DemoSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return array(
            MyFirstEvent::NAME => "onDemoEvent"
        );
    }

    public function onDemoEvent(MyFirstEvent $event): void
    {
        // fetch event information here
        echo "DemoListener is called!\n";
        echo "The value of the foo is :".$event->getFoo()."\n";
    }
}
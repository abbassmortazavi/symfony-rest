<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class MyFirstEvent extends Event
{
    const NAME = 'demo.event';
    protected string $foo;
    public function __construct()
    {
        $this->foo = 'bar';
    }

    public function getFoo(): string
    {
        return $this->foo;
    }
}
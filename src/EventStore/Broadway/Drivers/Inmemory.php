<?php namespace Nwidart\LaravelBroadway\EventStore\Broadway\Drivers;

use Broadway\EventStore\InMemoryEventStore;
use Nwidart\LaravelBroadway\EventStore\Driver;

class Inmemory implements Driver
{
    /**
     * @return object
     */
    public function getDriver()
    {
        return new InMemoryEventStore();
    }
}

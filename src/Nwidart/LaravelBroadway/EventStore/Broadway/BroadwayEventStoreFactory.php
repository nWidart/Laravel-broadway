<?php namespace Nwidart\LaravelBroadway\EventStore\Broadway;

use Nwidart\LaravelBroadway\EventStore\EventStoreFactory;

class BroadwayEventStoreFactory implements EventStoreFactory
{
    /**
     * @param string $driver
     * @return \Nwidart\LaravelBroadway\EventStore\Driver
     */
    public function make($driver)
    {
        $driver = 'Nwidart\LaravelBroadway\EventStore\Broadway\Drivers\\' . ucfirst($driver);

        return new $driver;
    }
}

<?php namespace Nwidart\LaravelBroadway\EventStore;

interface EventStoreFactory
{
    /**
     * @param string $driver
     * @return \Nwidart\LaravelBroadway\EventStore\Driver
     */
    public function make($driver);
}

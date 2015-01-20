<?php namespace Nwidart\LaravelBroadway\ReadModel;

interface ReadModelFactory
{
    /**
     * @param string $driver
     * @return \Nwidart\LaravelBroadway\ReadModel\Driver
     */
    public function make($driver);
}

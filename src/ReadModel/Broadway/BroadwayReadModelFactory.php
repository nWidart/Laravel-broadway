<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway;

use Nwidart\LaravelBroadway\ReadModel\ReadModelFactory;

class BroadwayReadModelFactory implements ReadModelFactory
{
    /**
     * @param  string                                    $driver
     * @return \Nwidart\LaravelBroadway\ReadModel\Driver
     */
    public function make($driver)
    {
        $driver = 'Nwidart\LaravelBroadway\ReadModel\Broadway\Drivers\\' . ucfirst($driver);

        return new $driver();
    }
}

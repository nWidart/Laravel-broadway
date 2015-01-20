<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway;

use Nwidart\LaravelBroadway\ReadModel\ReadModelFactory;

class BroadwayReadModelFactory implements ReadModelFactory
{
    /**
     * @param string $driver
     * @return \Nwidart\LaravelBroadway\ReadModel\Driver
     */
    public function make($driver)
    {
        $driver = ucfirst($driver);

        return new $driver;
    }
}

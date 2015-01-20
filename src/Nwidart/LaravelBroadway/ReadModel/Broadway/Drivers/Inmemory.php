<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway\Drivers;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Nwidart\LaravelBroadway\ReadModel\Driver;

class Inmemory implements Driver
{
    /**
     * @return object
     */
    public function getDriver()
    {
        return new InMemoryRepository();
    }
}

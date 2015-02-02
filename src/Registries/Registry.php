<?php namespace Nwidart\LaravelBroadway\Registries;

interface Registry
{
    /**
     * @param array $handlers
     * @return void
     */
    public function add(array $handlers);
}

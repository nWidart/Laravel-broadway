<?php namespace Nwidart\LaravelBroadway\Registries;

interface Registry
{
    /**
     * @param  array $handlers
     * @return
     */
    public function subscribe($handlers);
}

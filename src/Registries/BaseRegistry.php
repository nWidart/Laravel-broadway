<?php namespace Nwidart\LaravelBroadway\Registries;

abstract class BaseRegistry
{
    /**
     * Check if the given argument is traversable
     * @param $argument
     * @return bool
     */
    protected function isTraversable($argument)
    {
        return is_array($argument) || $argument instanceof \Traversable;
    }
}

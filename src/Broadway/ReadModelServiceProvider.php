<?php namespace Nwidart\LaravelBroadway\Broadway;

use Illuminate\Support\ServiceProvider;

class ReadModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Nwidart\LaravelBroadway\ReadModel\ReadModelFactory::class,
            \Nwidart\LaravelBroadway\ReadModel\Broadway\BroadwayReadModelFactory::class
        );

        $driver = $this->app['config']->get('broadway.read-model');

        $this->app->singleton(ucfirst($driver), function ($app) use ($driver) {
            return $app[\Nwidart\LaravelBroadway\ReadModel\ReadModelFactory::class]->make($driver)->getDriver();
        });
    }
}

<?php namespace Nwidart\LaravelBroadway\Broadway;

use Illuminate\Support\ServiceProvider;

class ReadModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Nwidart\LaravelBroadway\ReadModel\ReadModelFactory',
            'Nwidart\LaravelBroadway\ReadModel\Broadway\BroadwayReadModelFactory'
        );

        $driver = $this->app['config']->get('broadway.read-model');

        $this->app->singleton(ucfirst($driver), function ($app) use ($driver) {
            return $app['Nwidart\LaravelBroadway\ReadModel\ReadModelFactory']->make($driver)->getDriver();
        });
    }
}

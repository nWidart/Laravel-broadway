<?php namespace Nwidart\LaravelBroadway\Broadway;

use Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class ReadModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Nwidart\LaravelBroadway\ReadModel\ReadModelFactory',
            'Nwidart\LaravelBroadway\ReadModel\Broadway\BroadwayReadModelFactory'
        );

        $this->app->singleton('Elasticsearch', function ($app) {
            $driver = $app['config']->get('laravel-broadway::read-model');

            return $app['Nwidart\LaravelBroadway\ReadModel\ReadModelFactory']->make($driver)->getDriver();
        });
    }
}

<?php namespace Nwidart\LaravelBroadway\Broadway;

use Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $driver = $this->app['config']->get('laravel-broadway::read-model');
        $config = $this->app['config']->get("laravel-broadway::read-model-connections.{$driver}.config");

        $this->app->singleton('Elasticsearch', function () use ($config) {
            return new Client($config);
        });
    }
}

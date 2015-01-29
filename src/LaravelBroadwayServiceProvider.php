<?php namespace Nwidart\LaravelBroadway;

use Illuminate\Support\ServiceProvider;

class LaravelBroadwayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = __DIR__ . '/../config/broadway.php';
        $this->mergeConfigFrom($configPath, 'broadway');
        $this->publishes([$configPath => config_path('broadway.php')]);

        $this->app->register('Nwidart\LaravelBroadway\Broadway\EventServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\CommandServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\SerializersServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\EventStorageServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\SupportServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\ReadModelServiceProvider');
    }
}

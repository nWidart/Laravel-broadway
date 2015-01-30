<?php namespace Nwidart\LaravelBroadway;

use Illuminate\Support\ServiceProvider;

class LaravelBroadwayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfiguration();
        $this->registerMigrations();

        $this->app->register('Nwidart\LaravelBroadway\Broadway\EventServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\CommandServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\SerializersServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\EventStorageServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\SupportServiceProvider');
        $this->app->register('Nwidart\LaravelBroadway\Broadway\ReadModelServiceProvider');
    }

    /**
     * Register the configuration file so Laravel can publish them
     * Also merges the published config file with original
     */
    private function registerConfiguration()
    {
        $configPath = __DIR__.'/../config/broadway.php';
        $this->mergeConfigFrom($configPath, 'broadway');
        $this->publishes([$configPath => config_path('broadway.php')]);
    }

    /**
     * Register the migrations so Laravel can publish them
     */
    private function registerMigrations()
    {
        $this->publishes([
            __DIR__.'/../migrations' => base_path('database/migrations'),
        ]);
    }
}

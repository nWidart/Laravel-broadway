<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\EventDispatcher\EventDispatcher;
use Broadway\EventHandling\SimpleEventBus;
use Illuminate\Support\ServiceProvider;
use Nwidart\LaravelBroadway\Console\CreateEventStoreCommand;
use Nwidart\LaravelBroadway\Registries\EventRegistry;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBindings();

        $this->registerCommands();
    }

    /**
     * Register artisan command to generate the event store table
     */
    private function registerCommands()
    {
        $this->app['laravel-broadway::event-store::migrate'] = $this->app->share(function () {
            return new CreateEventStoreCommand();
        });

        $this->commands('laravel-broadway::event-store::migrate');
    }

    /**
     * Register bindings on the IoC Container
     */
    private function registerBindings()
    {
        $this->app->singleton('Broadway\EventDispatcher\EventDispatcherInterface', function () {
            return new EventDispatcher();
        });

        $this->app->singleton('Broadway\EventHandling\EventBusInterface', function () {
            return new SimpleEventBus();
        });

        $this->app->bind('Nwidart\LaravelBroadway\Registries\EventRegistry', function ($app) {
            return new EventRegistry($app['Broadway\EventHandling\EventBusInterface']);
        });
    }
}

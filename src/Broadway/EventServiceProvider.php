<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\EventDispatcher\CallableEventDispatcher;
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
        $this->app->singleton('laravel-broadway::event-store::migrate', function () {
            return new CreateEventStoreCommand();
        });

        $this->commands('laravel-broadway::event-store::migrate');
    }

    /**
     * Register bindings on the IoC Container
     */
    private function registerBindings()
    {
        $this->app->singleton(\Broadway\EventDispatcher\EventDispatcher::class, function () {
            return new CallableEventDispatcher();
        });

        $this->app->singleton(\Broadway\EventHandling\EventBus::class, function () {
            return new SimpleEventBus();
        });

        $this->app->singleton('laravelbroadway.event.registry', function ($app) {
            return new EventRegistry($app[\Broadway\EventHandling\EventBus::class]);
        });
    }
}

<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\EventDispatcher\EventDispatcher;
use Broadway\EventHandling\SimpleEventBus;
use Illuminate\Support\ServiceProvider;
use Nwidart\LaravelBroadway\Commands\CreateEventStoreCommand;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Broadway\EventDispatcher\EventDispatcherInterface', function () {
            return new EventDispatcher();
        });

        $this->app->singleton('Broadway\EventHandling\EventBusInterface', function () {
            return new SimpleEventBus();
        });

        $this->registerCommands();
    }

    public function boot()
    {
        $this->registerEventSubscribers();
    }

    /**
     * Register the user set subscribers on the event bus
     */
    private function registerEventSubscribers()
    {
        try {
            $subscribers = $this->app['broadway.event-subscribers'];
        } catch (\ReflectionException $e) {
            // fallback to other places where event subscribes could be defined
            $subscribers = [];
        }

        foreach ($subscribers as $projector => $repository) {
            $repository = $this->app[$repository];
            $projector = new $projector($repository);
            $this->app['Broadway\EventHandling\EventBusInterface']->subscribe($projector);
        }
    }

    /**
     * Register artisan command to generate the event store table
     */
    private function registerCommands()
    {
        $this->app['laravel-broadway::migrate'] = $this->app->share(function()
        {
            return new CreateEventStoreCommand();
        });

        $this->commands('laravel-broadway::migrate');
    }
}

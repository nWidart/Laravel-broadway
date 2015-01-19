<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\EventDispatcher\EventDispatcher;
use Broadway\EventHandling\SimpleEventBus;
use Illuminate\Support\ServiceProvider;

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
            dd('fallback to other places where event subscribes could be defined');
        }

        foreach ($subscribers as $projector => $repository) {
            $repository = $this->app[$repository];
            $projector = new $projector($repository);
            $this->app['Broadway\EventHandling\EventBusInterface']->subscribe($projector);
        }
    }
}

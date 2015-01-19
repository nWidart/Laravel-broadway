<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\CommandHandling\SimpleCommandBus;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Broadway\CommandHandling\CommandBusInterface', function () {
            return new SimpleCommandBus();
        });
    }

    public function boot()
    {
        $this->registerCommandSubscribers();
    }

    /**
     * Register the user set subscribers on the command bus
     */
    private function registerCommandSubscribers()
    {
        try {
            $subscribers = $this->app['broadway.command-subscribers'];
        } catch (\ReflectionException $e) {
            dd('fallback to other places where command subscribes could be defined');
        }

        foreach ($subscribers as $handler => $eventStoreRepository) {
            $esRepository = $this->app[$eventStoreRepository];
            $handler = new $handler($esRepository);
            $this->app['Broadway\CommandHandling\CommandBusInterface']->subscribe($handler);
        }
    }
}

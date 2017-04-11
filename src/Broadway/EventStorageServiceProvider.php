<?php namespace Nwidart\LaravelBroadway\Broadway;

use Illuminate\Support\ServiceProvider;

class EventStorageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Nwidart\LaravelBroadway\EventStore\EventStoreFactory::class,
            \Nwidart\LaravelBroadway\EventStore\Broadway\BroadwayEventStoreFactory::class
        );

        $this->app->bind(
            \Broadway\EventSourcing\AggregateFactory\AggregateFactory::class,
            \Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory::class
        );

        $this->app->bind(\Broadway\EventStore\EventStore::class, function ($app) {
            $driver = $app['config']->get('broadway.event-store.driver');

            return $app[\Nwidart\LaravelBroadway\EventStore\EventStoreFactory::class]->make($driver)->getDriver();
        });
    }
}

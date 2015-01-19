<?php namespace Nwidart\LaravelBroadway;

use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\EventDispatcher\EventDispatcher;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\DBALEventStore;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;

class LaravelBroadwayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindEventClasses();
        $this->bindCommandClasses();
        $this->bindSerializers();
        $this->bindEventStorage();
        $this->bindMiscClasses();
    }

    public function boot()
    {
        $this->registerCommandSubscribers();
        $this->registerEventSubscribers();
    }

    /**
     * Bind all classes event related classes
     */
    private function bindEventClasses()
    {
        $this->app->singleton('Broadway\EventDispatcher\EventDispatcherInterface', function () {
            return new EventDispatcher();
        });

        $this->app->singleton('Broadway\EventHandling\EventBusInterface', function () {
            return new SimpleEventBus();
        });
    }

    /**
     * Bind all command related classes
     */
    private function bindCommandClasses()
    {
        $this->app->singleton('Broadway\CommandHandling\CommandBusInterface', function () {
            return new SimpleCommandBus();
        });
    }

    /**
     * Bind the Serializer
     */
    private function bindSerializers()
    {
        $this->app->bind('Broadway\Serializer\SerializerInterface', function () {
            return new SimpleInterfaceSerializer();
        });
    }

    /**
     * Bind the event storage class
     */
    private function bindEventStorage()
    {
        $connectionParams = $this->getStorageConnectionParameters();
        $this->app->bind('Broadway\EventStore\EventStoreInterface', function ($app) use ($connectionParams) {
            $configuration = new Configuration();

            $connection = DriverManager::getConnection($connectionParams, $configuration);
            $payloadSerializer = $app['Broadway\Serializer\SerializerInterface'];
            $metadataSerializer = $app['Broadway\Serializer\SerializerInterface'];
            return new DBALEventStore($connection, $payloadSerializer, $metadataSerializer, 'event_store');
        });
    }

    /**
     * Bind miscellaneous helper classes
     */
    private function bindMiscClasses()
    {
        // Bind a Uuid Generator
        $this->app->bind('Broadway\UuidGenerator\UuidGeneratorInterface', function () {
            return new Version4Generator();
        });
    }

    /**
     * Make a connection parameters array based on the laravel configuration
     * @return array
     */
    private function getStorageConnectionParameters()
    {
        $driver = $this->app['config']->get('database.default');
        $connectionParams = $this->app['config']->get("database.connections.{$driver}");

        $connectionParams['dbname'] = $connectionParams['database'];
        $connectionParams['user'] = $connectionParams['username'];
        unset($connectionParams['database'], $connectionParams['username']);
        $connectionParams['driver'] = "pdo_$driver";

        return $connectionParams;
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

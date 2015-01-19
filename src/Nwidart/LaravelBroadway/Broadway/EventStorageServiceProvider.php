<?php namespace Nwidart\LaravelBroadway\Broadway;

use Broadway\EventStore\DBALEventStore;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;

class EventStorageServiceProvider extends ServiceProvider
{
    public function register()
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
}

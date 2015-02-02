<?php namespace Nwidart\LaravelBroadway\EventStore\Broadway\Drivers;

use Broadway\EventStore\DBALEventStore;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Nwidart\LaravelBroadway\EventStore\Driver;

class Dbal implements Driver
{
    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;

    public function __construct()
    {
        $this->config = app('Illuminate\Config\Repository');
    }

    /**
     * @return object
     */
    public function getDriver()
    {
        $configuration = new Configuration();

        $connectionParams = $this->getStorageConnectionParameters();
        $connection = DriverManager::getConnection($connectionParams, $configuration);
        $payloadSerializer = app('Broadway\Serializer\SerializerInterface');
        $metadataSerializer = app('Broadway\Serializer\SerializerInterface');

        $table = $this->config->get('broadway.event-store.table', 'event_store');

        $app = app();
        $app->singleton('Doctrine\DBAL\Connection', function () use ($connection) {
            return $connection;
        });

        return new DBALEventStore($connection, $payloadSerializer, $metadataSerializer, $table);
    }

    /**
     * Make a connection parameters array based on the laravel configuration
     * @return array
     */
    private function getStorageConnectionParameters()
    {
        $driver = $this->config->get('database.default');
        $connectionParams = $this->config->get("database.connections.{$driver}");

        $connectionParams['dbname'] = $connectionParams['database'];
        $connectionParams['user'] = $connectionParams['username'];
        unset($connectionParams['database'], $connectionParams['username']);
        $connectionParams['driver'] = "pdo_$driver";

        return $connectionParams;
    }
}

<?php namespace Nwidart\LaravelBroadway\EventStore\Broadway\Drivers;

use Broadway\EventStore\Dbal\DBALEventStore;
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
        $this->config = app(\Illuminate\Config\Repository::class);
    }

    /**
     * @return object
     */
    public function getDriver()
    {
        $configuration = new Configuration();

        $connectionParams = $this->getStorageConnectionParameters();
        $connection = DriverManager::getConnection($connectionParams, $configuration);
        $payloadSerializer = app(\Broadway\Serializer\Serializer::class);
        $metadataSerializer = app(\Broadway\Serializer\Serializer::class);

        $binaryUuidConverter = app(\Broadway\UuidGenerator\Converter\BinaryUuidConverter::class);

        $table = $this->config->get('broadway.event-store.table', 'event_store');

        $app = app();
        $app->singleton(\Doctrine\DBAL\Connection::class, function () use ($connection) {
            return $connection;
        });

        return new DBALEventStore($connection, $payloadSerializer, $metadataSerializer, $table, false, $binaryUuidConverter);
    }

    /**
     * Make a connection parameters array based on the laravel configuration
     * @return array
     */
    private function getStorageConnectionParameters()
    {
        $databaseConnectionName = $this->config->get('broadway.event-store.connection', 'default');
        $connectionParams = $this->config->get("database.connections.{$databaseConnectionName}");

        $connectionParams['dbname'] = $connectionParams['database'];
        $connectionParams['user'] = $connectionParams['username'];
        unset($connectionParams['database'], $connectionParams['username']);
        $connectionParams['driver'] = "pdo_".$connectionParams['driver'];

        return $connectionParams;
    }
}

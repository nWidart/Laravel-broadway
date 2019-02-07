<?php namespace Nwidart\LaravelBroadway\EventStore\Broadway\Drivers;

use Aws\DynamoDb\DynamoDbClient;
use Broadway\EventStore\DynamoDb\DynamoDbEventStore;
use Nwidart\LaravelBroadway\EventStore\Driver;
use Aws\Credentials\Credentials;

class DynamoDb implements Driver
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
        $payloadSerializer = app(\Broadway\Serializer\Serializer::class);
        $metadataSerializer = app(\Broadway\Serializer\Serializer::class);

        $table = $this->config->get('broadway.event-store.table', 'event_store');
        $endpoint =  $this->config->get('broadway.event-store.endpoint', '');
        $accessKeyId =  $this->config->get('broadway.event-store.access_key_id', '');
        $secretAccessKey =  $this->config->get('broadway.event-store.secret_access_key', '');
        $region =  $this->config->get('broadway.event-store.region', '');

        $credentials = new Credentials($accessKeyId, $secretAccessKey);
        $dynamoDbClient = DynamoDbClient::factory([
            'region' => $region,
            'credentials' => $credentials,
            'version' => 'latest',
            'endpoint' => $endpoint
        ]);

        $app = app();
        $app->singleton(\Aws\DynamoDb\DynamoDbClient::class, function () use ($dynamoDbClient) {
            return $dynamoDbClient;
        });

        return new DynamoDbEventStore($dynamoDbClient, $payloadSerializer, $metadataSerializer, $table);
    }
}

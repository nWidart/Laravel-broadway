<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway\Drivers;

use Nwidart\LaravelBroadway\ReadModel\Driver;

class Elasticsearch implements Driver
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
        $config = $this->config->get('broadway.read-model-connections.elasticsearch.config');

        // elasticsearch v2.0 using builder
        if (class_exists(\Elasticsearch\ClientBuilder::class)) {
            return \Elasticsearch\ClientBuilder::fromConfig($config);
        }
        // elasticsearch v1
        return new \Elasticsearch\Client($config);
    }
}

<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway\Drivers;

use Elasticsearch\Client;
use Illuminate\Config\Repository;
use Nwidart\LaravelBroadway\ReadModel\Driver;

class Elasticsearch implements Driver
{
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @return object
     */
    public function getDriver()
    {
        $config = $this->config->get('laravel-broadway::read-model-connections.elasticsearch');

        return new Client($config);
    }
}

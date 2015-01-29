<?php namespace Nwidart\LaravelBroadway\ReadModel\Broadway\Drivers;

use Elasticsearch\Client;
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
        $config = $this->config->get('laravel-broadway::read-model-connections.elasticsearch.config');

        return new Client($config);
    }
}

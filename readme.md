# Laravel Broadway

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/092c1ed2-24a2-4aac-bf91-822dc9df98e4/mini.png)](https://insight.sensiolabs.com/projects/092c1ed2-24a2-4aac-bf91-822dc9df98e4)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nWidart/Laravel-broadway/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nWidart/Laravel-broadway/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/nwidart/laravel-broadway/version.svg)](https://packagist.org/packages/nwidart/laravel-broadway)
[![Total Downloads](https://poser.pugx.org/nwidart/laravel-broadway/downloads.svg)](https://packagist.org/packages/nwidart/laravel-broadway)
[![Latest Unstable Version](https://poser.pugx.org/nwidart/laravel-broadway/v/unstable.svg)](//packagist.org/packages/nwidart/laravel-broadway)
[![License](https://poser.pugx.org/nwidart/laravel-broadway/license.svg)](https://packagist.org/packages/nwidart/laravel-broadway)

Laravel Broadway is an adapter for the [Broadway](https://github.com/qandidate-labs/broadway/) package.

It binds all needed interfaces for Broadway.

For reference, I've built a [demo laravel application](https://github.com/nWidart/Laravel-Broadway-Demo) that uses this package and some event sourcing techniques. 

## Installation

### Install via composer

```
composer require nwidart/laravel-broadway=~0.2
```

### Service Providers

To finish the installation you need to add the service providers. 

You have a choice here, you can either use the main Service Provider which will load the following:
 
- [CommandBus](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/CommandServiceProvider.php)
- [EventBus](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/EventServiceProvider.php)
- [Serializers](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/SerializersServiceProvider.php)
- [EventStorage](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/EventStorageServiceProvider.php)
- [ReadModel](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/ReadModelServiceProvider.php)
- [Support](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/SupportServiceProvider.php) (UuidGenerators,...)

Or choose to use only the Service providers you need. Don't know what you need ? Use the Global Service Provider provided.

#### Global Service Provider
 
 ``` php
    'Nwidart\LaravelBroadway\LaravelBroadwayServiceProvider'
 ```

#### Separate Service Providers
 
 - CommandBus
 
    ``` php
    'Nwidart\LaravelBroadway\Broadway\CommandServiceProvider'
    ```
    
- EventBus

    ``` php
    'Nwidart\LaravelBroadway\Broadway\EventServiceProvider'
    ```

- Serializers

    ``` php
    'Nwidart\LaravelBroadway\Broadway\SerializersServiceProvider'
    ```

- EventStorage

    ``` php
    'Nwidart\LaravelBroadway\Broadway\EventStorageServiceProvider'
    ```

- ReadModel

    ``` php
    'Nwidart\LaravelBroadway\Broadway\ReadModelServiceProvider'
    ```

- Support

    ``` php
    'Nwidart\LaravelBroadway\Broadway\SupportServiceProvider'
    ```

### (optional) Publish configuration


```
php artisan config:publish nwidart/laravel-broadway
```


## Configuration

### Event Store

To create the event store you can call the following command:

```
php artisan broadway:event-store:migrate table_name
```
In the configuration file, you can choose which driver to use as an event store.

``` php
'event-store' => [
    'table' => 'event_store',
    'driver' => 'dbal'
],
```



### Read Model

To set a read model in your application you first need to set the wanted read model in the package configuration. 

Once that's done you can bind a ReadModelRepository like so:


``` php
$this->app->bind('Modules\Parts\Repositories\ReadModelPartRepository', function ($app) {
    $serializer = $app['Broadway\Serializer\SerializerInterface'];
    return new ElasticSearchReadModelPartRepository($app['Elasticsearch'], $serializer);
});
```

For an In Memory read model as an example:

``` php
$this->app->bind('Modules\Parts\Repositories\ReadModelPartRepository', function ($app) {
    $serializer = $app['Broadway\Serializer\SerializerInterface'];
    return new InMemoryReadModelPartRepository($app['Inmemory'], $serializer);
});
```



See the [demo laravel application](https://github.com/nWidart/Laravel-Broadway-Demo) and specifically the [Service Provider](https://github.com/nWidart/Laravel-Broadway-Demo/blob/master/Modules/Parts/PartServiceProvider.php) for an working example.


***

## [Changelog](/CHANGELOG.md)
## [License (MIT)](/LICENSE.md)

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

**Laravel 5 compatible package**

| Laravel version  | Package version |
| ---------------- | --------------- |
| ~4.2  | ~2.0  |
| ~5  | ~3.0 *(comming)*  |

## Installation

### Install via composer

```
composer require nwidart/laravel-broadway=~2.0
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

### (Optional) Publish configuration file and migration

```
php artisan vendor:publish
```

This will publish a `config/broadway.php` file and a `database/migrations/create_event_store_table.php` file.


### (Optional) Run migration

Last step, run the migration that was published in the last step to create the event_store table.

If you haven't published the vendor files, you can use the command explained below:

```
php artisan broadway:event-store:migrate table_name
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

Once done, you can bind your **EventStoreRepositories** in a Service Provider like so:

``` php
$this->app->bind('Modules\Parts\Repositories\EventStorePartRepository', function ($app) {
    $eventStore = $app['Broadway\EventStore\EventStoreInterface'];
    $eventBus = $app['Broadway\EventHandling\EventBusInterface'];
    return new MysqlEventStorePartRepository($eventStore, $eventBus);
});
```

For an in memory Event Store, all you need to do is change the driver in the configuration file and probably add a new event store repository implementation with an adequate name.


### Read Model

To set a read model in your application you first need to set the wanted read model in the package configuration. 

Once that's done you can bind your **ReadModelRepositories** in a Service Provider like so:


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



See the [demo laravel application](https://github.com/nWidart/Laravel-Broadway-Demo) and specifically the [Service Provider](https://github.com/nWidart/Laravel-Broadway-Demo/blob/master/Modules/Parts/PartServiceProvider.php) for a working example.


## Registering subscribers

### Command handlers

To let broadway know which handlers are available you need to bind in the Laravel IoC container a key named `broadway.command-subscribers` as a singleton. 

It's important to know Command Handlers classes in broadway need to get a Event Store repository injected. 

Now just pass either an array of command handlers to the `laravelbroadway.command.registry` key out the IoC Container or juste one class, like so:


``` php
$partCommandHandler = new PartCommandHandler($this->app['Modules\Parts\Repositories\EventStorePartRepository']);
$someOtherCommandHandler = new PartCommandHandler($this->app['Modules\Things\Repositories\EventStoreSomeRepository']);

$this->app['laravelbroadway.command.registry']->subscribe([
    $partCommandHandler,
    $someCommandHandler
]);

// OR

$this->app['laravelbroadway.command.registry']->subscribe($partCommandHandler);
$this->app['laravelbroadway.command.registry']->subscribe($someOtherCommandHandler);
```

### Event subscribers

This is pretty much the same as the command handlers, except that the event subscriber (or listener) needs an Read Model repository.

Example:

``` php
$partsThatWereManfacturedProjector = new PartsThatWereManufacturedProjector($this->app['Modules\Parts\Repositories\ReadModelPartRepository']);
$someOtherProjector = new SomeProjector($this->app['Modules\Things\Repositories\ReadModelSomeRepository']);

$this->app['laravelbroadway.event.registry']->subscribe([
    $partsThatWereManfacturedProjector,
    $partsThatWereManfacturedProjector
]);

// OR

$this->app['laravelbroadway.event.registry']->subscribe($partsThatWereManfacturedProjector);
$this->app['laravelbroadway.event.registry']->subscribe($someOtherProjector);

```

All the rest are conventions from the Broadway package.




***

## [Changelog](/CHANGELOG.md)
## [License (MIT)](/LICENSE.md)

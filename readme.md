# Laravel Broadway

Laravel Broadway is an adapter for the [Broadway](https://github.com/qandidate-labs/broadway/) package.

It binds all needed interfaces for Broadway.

For reference, I've built a [demo laravel application](https://github.com/nWidart/Laravel-Broadway-Demo) that uses this package and some event sourcing techniques. 

## Installation

### Install via composer

```
composer require nwidart/laravel-broadway=~0.1
```

### Service Providers

To finish the installation you need to add the service providers. 

You have a choice here, you can either use the main Service Provider which will load the following:
 
- [CommandBus](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/CommandServiceProvider.php)
- [EventBus](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/EventServiceProvider.php)
- [Serializers](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/SerializersServiceProvider.php)
- [EventStorage](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/EventStorageServiceProvider.php)
- [ElasticSearch](https://github.com/nWidart/Laravel-broadway/blob/master/src/Nwidart/LaravelBroadway/Broadway/ElasticSearchServiceProvider.php)
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

- ElasticSearch

    ``` php
    'Nwidart\LaravelBroadway\Broadway\ElasticSearchServiceProvider'
    ```

- Support

    ``` php
    'Nwidart\LaravelBroadway\Broadway\SupportServiceProvider'
    ```

### (optional) Publish configuration


```
php artisan config:publish nwidart/laravel-broadway
```


## [License (MIT)](/LICENSE.md)

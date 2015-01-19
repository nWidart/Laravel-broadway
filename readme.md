# Laravel Broadway

Laravel Broadway is an adapter for the [Broadway](https://github.com/qandidate-labs/broadway/) package.

It binds all needed interfaces for Broadway.

## Installation

### Install via composer

```
composer require nwidart/laravel-broadway=~0.1
```

### Service Providers

To finish the installation you need to add the service providers. 

You have a choice here, you can either use the main Service Provider which will load the following:
 
- CommandBus
- EventBus
- Serializers
- EventStorage
- ElasticSearch
- Support (UuidGenerators,...)

Or choice to use only the Service providers you need. Don't know what you need ? Use the Global Service Provider provided.

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

## [License (MIT)](/LICENSE.md)

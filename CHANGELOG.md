# Change Log
All notable changes to this project will be documented in this file.

## [0.2.0]() - T.B.D.

### Added

- New command: `php artisan broadway:event-store:migrate table_name` to create the event store table
- Read Model: A factory is now instantiating the read model implementation based on the setting
- Read Model: An In Memory read model driver is now available
- Event Store: A factory is now instantiating the event store implementation based on the setting
- Event Store: An In Memory event store driver is now available

### Changed

- IoC key name of the Elasticsearch client from `elastic-search` to `Elasticsearch`
- Config: Change the read-model key name of `elastic-search` to `elasticsearch`


## [0.1.0](https://github.com/nWidart/Laravel-broadway/releases/tag/0.1) - 2015-01-19

First tagged version


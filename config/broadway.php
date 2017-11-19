<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Event Store configuration
    |--------------------------------------------------------------------------
    | Set the table name where the event will be stored. Make sure
    | this corresponds to what you specified in the migration
    |
    | You should also choose a driver, possible options are
    | dbal, inmemory
    */
    'event-store' => [
        'table' => 'event_store',
        'driver' => 'dbal',
    ],

    /*
    |--------------------------------------------------------------------------
    | Choose which read model implementation to use
    | Possible options are: inmemory (default), elasticsearch
    |--------------------------------------------------------------------------
    */

    'read-model' => 'inmemory',
    'read-model-connections' => [
        'elasticsearch' => [
            'config' => [
                'hosts' => ['localhost:9200'],
            ],
        ],
    ],
];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table name where the events will be stored
    |--------------------------------------------------------------------------
    */
    'event-store-table' => 'event_store',

    /*
    |--------------------------------------------------------------------------
    | Choose which read model implementation to use
    | Possible options are: elasticsearch, inmemory
    |--------------------------------------------------------------------------
    */
    'read-model' => 'elasticsearch',
    'read-model-connections' => [
        'elasticsearch' => [
            'config' => [
                'hosts' => ['localhost:9200'],
            ],
        ],
    ],
];

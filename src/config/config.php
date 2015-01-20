<?php

return [
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

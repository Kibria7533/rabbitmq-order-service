<?php

return [
    'exchanges' => [
        'user' => [
            'name' => 'user.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'user.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'user.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'user.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'orderMake' => [
                    'name' => 'user.q',
                    'binding' => 'user',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'user.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ]
    ],
    'consume' => ''
];

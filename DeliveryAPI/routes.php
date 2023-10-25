<?php

$routes = [
    'delivery' => [
        'controller' => 'deliveryApiController',
        'strategy' => [
            'calculate-fast-delivery' => 'fastDelivery',
            'calculate-slow-delivery' => 'slowDelivery'
        ],
        'actions' => [
            'calculate-fast-delivery' => 'resolve',
            'calculate-slow-delivery' => 'resolve'
        ],
        'methods' => ['POST']
    ]
];
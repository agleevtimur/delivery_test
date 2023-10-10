<?php

$routes = [
    'delivery' => [
        'controller' => 'deliveryApiController',
        'actions' => [
            'calculate-fast-delivery' => 'calculateFastDeliveryPrice',
            'calculate-slow-delivery' => 'calculateSlowDeliveryCoefficient'
        ]
    ]
];
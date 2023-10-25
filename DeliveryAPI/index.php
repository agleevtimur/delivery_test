<?php

use API\DelovyeLinii\DelovyeLiniiApi;
use API\PEK\PekApi;
use Controller\DeliveryApiController;
use GuzzleHttp\Client;
use Service\FastDeliveryService;
use Service\SlowDeliveryService;

include 'routes.php';
spl_autoload_register(fn($className) => include str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php');
require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$urlParts = explode('/', $uri);
$deliveryStrategy = $routes['delivery']['strategy'][array_pop($urlParts)];

$serviceManager = new ServiceManager();

$serviceManager->addService('pekApi', fn() => new PekApi(new Client(['base_uri' => getenv('PEK_API_HOSTNAME')])));
$serviceManager->addService('delovyeLiniiApi', fn() => new DelovyeLiniiApi(new Client(['base_uri' => getenv('DELOVYE_LINII_API_HOSTNAME')])));
$serviceManager->addService(
    'transportCompanyApiList',
    fn() => [
        'delovyeLiniiApi' => $serviceManager->get('delovyeLiniiApi'),
        'pekApi' => $serviceManager->get('pekApi'),
        'all' => [
            'delovyeLiniiApi' => $serviceManager->get('delovyeLiniiApi'),
            'pekApi' => $serviceManager->get('pekApi')
        ]
    ],
);

$serviceManager->addService('slowDelivery', fn() => new SlowDeliveryService());
$serviceManager->addService('fastDelivery', fn() => new FastDeliveryService());

$serviceManager->addService(
    'deliveryApiController',
    fn() => new DeliveryApiController($serviceManager->get('transportCompanyApiList'), $serviceManager->get($deliveryStrategy))
);

$router = new Router($serviceManager, $routes);
$router->dispatch($uri);

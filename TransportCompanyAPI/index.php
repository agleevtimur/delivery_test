<?php

use API\DelovyeLinii\DelovyeLiniiApi;
use API\PEK\PekApi;
use Controller\DeliveryApiController;
use GuzzleHttp\Client;
use Repository\PriceHistoryRepository;

include 'routes.php';
spl_autoload_register(fn($className) => include str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php');
require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$parameters = $routes[$uri] ?? null;

$serviceManager = new ServiceManager();
$serviceManager->addService(
    'database',
    fn()=> new PDO("pgsql:host=localhost;dbname=delivery_api;user=delivery_api_user;password=123")
);
$serviceManager->addService(
    'logisticDataRepository',
    fn() => new PriceHistoryRepository($serviceManager->get('database'))
);
$serviceManager->addService(
    'transportCompanyApiList',
    fn() => [
        'delovyeLiniiApi' => new DelovyeLiniiApi($serviceManager->get('logisticDataRepository'), new Client(['base_uri' => 'http://localhost:8001/'])),
        'pekApi' => new PekApi(new Client(['base_uri' => 'http://localhost:8002']))
    ]
);
$serviceManager->addService(
    'deliveryApiController',
    fn() => new DeliveryApiController($serviceManager->get('transportCompanyApiList')));

$router = new Router($serviceManager, $routes);
$router->dispatch($uri);

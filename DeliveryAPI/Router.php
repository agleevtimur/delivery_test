<?php

class Router
{
    private ServiceManager $serviceManager;
    private array $routeMapping;

    public function __construct(ServiceManager $serviceManager, array $routeMapping)
    {
        $this->serviceManager = $serviceManager;
        $this->routeMapping = $routeMapping;
    }

    public function dispatch(string $url)
    {
        $url = trim($url, '/');
        $urlParts = explode('/', $url);
        $this->allowCors();

        if (isset($this->routeMapping[$urlParts[0]])) {
            $container = $this->routeMapping[$urlParts[0]] ?? [];
            $controller = $this->serviceManager->get($container['controller'] ?? '');
            $action = $container['actions'][$urlParts[1]] ?? '';
            $methods = $container['methods'];

            if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
                die();
            }

            if (method_exists($controller, $action) && in_array($_SERVER['REQUEST_METHOD'], $methods)) {
                call_user_func_array([$controller, $action], []);
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }

    private function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo 'Страница не найдена';
    }

    private function allowCors()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
    }
}

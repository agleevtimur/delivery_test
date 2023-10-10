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

        if (isset($this->routeMapping[$urlParts[0]])) {
            $container = $this->routeMapping[$urlParts[0]] ?? [];
            $controller = $this->serviceManager->get($container['controller'] ?? '');
            $action = $container['actions'][$urlParts[1]] ?? '';
//            var_dump($controller, $action);
//            $controller = $controller();
            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], []);
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }

    private function notFound() {
        header("HTTP/1.0 404 Not Found");
        echo 'Страница не найдена';
    }
}

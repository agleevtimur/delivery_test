<?php

class ServiceManager
{
    private array $container = [];

    public function addService(string $name, Closure $closure)
    {
        $this->container[$name] = $closure;
    }

    public function get(string $name)
    {
        return $this->container[$name]() ?? null;
    }
}
<?php

namespace Core\DI;

class Repository
{
    private $services = [];

    public function get($key)
    {
        if (! isset($this->services[$key])) {
            return null;
        }

        return $this->services[$key];
    }

    /**
     * @param $key
     * @param $service
     * @return void
     */
    public function add($key, $service)
    {
        if ($service instanceof \Closure) {
            $service = call_user_func($service, $this);
        }
        $this->services[$key] = $service;
    }

    public function has($key)
    {
        return key_exists($key, $this->services);
    }
}


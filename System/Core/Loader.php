<?php

namespace Core;

class Loader
{
    private $controllers = [];

    private $models = [];

    private $container;

    public function __construct()
    {
        $this->container = DI\Container::getInstance();
    }

    public function action($controller, $method, array $arguments = [])
    {
        $object = $this->controller($controller);

        return call_user_func_array([$object, $method], $arguments);
    }

    public function controller($controller)
    {
        $controller = $this->getControllerName($controller);
        if (! $this->hasController($controller)) {
            $this->addController($controller);
        }

        return $this->getController($controller);
    }

    private function getControllerName($controller)
    {
        $controller .= 'Controller';
        $controller = 'App\\Controllers\\'.$controller;

        return str_replace('/', '\\', $controller);
    }

    private function hasController($controller)
    {
        return array_key_exists($controller, $this->controllers);
    }

    private function addController($controller)
    {
        $object = new $controller($this->container);
        $this->controllers[$controller] = $object;
    }

    private function getController($controller)
    {
        return $this->controllers[$controller];
    }

    public function model($model)
    {
        $model = $this->getModelName($model);
        if (! $this->hasModel($model)) {
            $this->addModel($model);
        }

        return $this->getModel($model);
    }

    private function getModelName($model)
    {
        $model .= 'Model';
        $model = 'App\\Models\\'.$model;

        return str_replace('/', '\\', $model);
    }

    private function hasModel($model)
    {
        return array_key_exists($model, $this->models);
    }

    private function addModel($model)
    {
        $object = new $model($this->container);
        $this->models[$model] = $object;
    }

    private function getModel($model)
    {
        return $this->models[$model];
    }
}

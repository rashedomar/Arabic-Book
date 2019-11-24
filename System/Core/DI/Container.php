<?php

namespace Core\DI;

class Container
{
    /**
     * App Object
     *
     * @var \Core\App
     */
    private static $instance = null;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @param Factory $factory
     * @param Repository $repository
     * @internal param string $configFile - path to json config file containing the services
     */
    private function __construct(Factory $factory, Repository $repository)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * create only one instance of this app (Singleton design pattern)
     *
     * @param Factory|null $factory
     * @param Repository|null $repository
     * @return \Core\App|Container
     */
    public static function getInstance(Factory $factory = null, Repository $repository = null)
    {
        if (is_null(static::$instance)) {
            self::$instance = new self($factory, $repository);
        }

        return self::$instance;
    }

    /**
     * Gets the instance via lazy initialization (created on first usage)
     *
     * @param $id
     * @param bool $create
     * @return mixed
     */
    public function get($id, $create = true)
    {

        $service = $this->repository->get($id);
        if ($create) {
            if (is_null($service)) {
                $service = $this->factory->create($id, $this);
                $this->repository->add($id, $service);
            }
        }

        return $service;
    }

    public function addService($key, $value)
    {
        $this->repository->add($key, $value);
    }

    public function has($key)
    {
        return $this->repository->has($key);
    }
}



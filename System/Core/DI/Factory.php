<?php

namespace Core\DI;

use OutOfRangeException;

class Factory
{
    /**
     * @var array
     */
    private $serviceList;

    /**
     * @var Json Object
     */
    private $jsonObj;

    /**
     * @var config json file with the services
     */
    private $jsonConfigFile;

    /**
     * @param string $configFile
     */
    public function __construct($configFile)
    {
        $this->jsonConfigFile = $configFile;
        $this->loadServiceList();
    }

    private function loadServiceList()
    {
        $this->loadJsonFile();
        foreach ($this->jsonObj->services as $service) {
            $this->serviceList[$service->key] = $service;
        }
    }

    private function loadJsonFile()
    {
        $string = file_get_contents($this->jsonConfigFile);
        $this->jsonObj = json_decode($string);
    }

    /**
     * @param string $id - a known id key
     * @param Container $container
     * @return mixed - a registered service
     * @throws \InvalidArgumentException
     */
    public function create($id, Container $container)
    {
        if (! $this->has($id)) {
            throw new OutOfRangeException($id.' Does Not Exists!');
        }

        return $this->instantiateService($id, $container);
    }

    public function has($id)
    {
        return array_key_exists($id, $this->serviceList);
    }

    /**
     * Use reflection to instantiate new objects
     *
     * @param           $id
     * @param Container $container
     * @return mixed - any object
     */
    private function instantiateService($id, Container $container)
    {
        $serviceData = $this->serviceList[$id];
        $reflector = new \ReflectionClass($serviceData->class);

        return $reflector->newInstanceArgs($this->getArgs($serviceData, $container));
    }

    /**
     * @param \stdClass $serviceData
     * @param Container $container
     * @return array
     */
    private function getArgs(\stdClass $serviceData, Container $container)
    {
        $args = [];
        if (isset($serviceData->arguments)) {
            foreach ($serviceData->arguments as $arg) {
                // recurse back to the container to find dependencies
                $args[] = $container->get($arg->arg);
            }
        }

        return $args;
    }
}


<?php

namespace Core;

/**
 * Class Controller
 */
abstract class Controller
{
    /**
     * container object
     *
     * @var \Core\DI\Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Core\DI\Container object
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * get container values by the given $key
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->container->get($key);
    }

    /**
     * get a string containing the JSON representation of the supplied values or data.
     *
     * @param $data
     * @return string
     */
    public function json($data)
    {
        return json_encode($data);
    }
}

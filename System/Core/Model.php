<?php

namespace Core;

abstract class Model
{
    protected $container;

    protected $table;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function all()
    {
        return $this->get('db')->fetchAll($this->table);
    }

    public function get($key)
    {
        return $this->container->get($key);
    }

    public function getID($id)
    {
        return $this->get('db')->where('id = ?', $id)->fetch($this->table);
    }

    public function exists($value, $key = 'id')
    {
        return (bool) $this->get('db')->select($key)->where($key.'= ?', $value)->fetch($this->table);
    }

    public function delete($id)
    {
        return $this->get('db')->where('id = ?', $id)->delete($this->table);
    }
}

?>

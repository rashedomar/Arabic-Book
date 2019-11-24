<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $connection;

    private $app;

    private $table;

    private $data = [];

    private $bindings = [];

    private $wheres = [];

    private $havings = [];

    private $groupby = [];

    private $selects = [];

    private $joins = [];

    private $limit;

    private $offset;

    private $lastId;

    private $orderby = [];

    private $rows = 0;

    public function __construct()
    {
        if (! $this->isConnected()) {
            $this->connect();
        }
    }

    private function isConnected()
    {
        return static::$connection instanceof PDO;
    }

    private function connect()
    {

        $db = require_once ROOT.DS.APP_DIR.DS.'config.php';
        try {

            static::$connection = new PDO('mysql:host='.$db['db_host'].';dbname='.$db['db_name'], $db['db_user'], $db['db_pass']);
            static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            static::$connection->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function from($table)
    {

        return $this->table($table);
    }

    public function table($table)
    {

        $this->table = $table;

        return $this;
    }

    public function data($key, $value = null)
    {

        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
            $this->addToBindings($key);
        } else {
            $this->data[$key] = $value;
            $this->addToBindings($value);
        }

        return $this;
    }

    private function addToBindings($value)
    {
        if (is_array($value)) {
            $this->bindings = array_merge($this->bindings, array_values($value));
        } else {
            $this->bindings[] = $value;
        }
    }

    public function insert($table = null)
    {
        if ($table) {
            $this->table($table);
        }
        $sql = 'INSERT INTO '.$this->table.' SET ';
        $sql .= $this->setFileds();

        $this->query($sql, $this->bindings);
        $this->lastId = $this->getConnection()->lastInsertId();
        $this->reset();

        return $this;
    }

    private function setFileds()
    {
        $sql = '';
        foreach (array_keys($this->data) as $key) {
            $sql .= $key.'= ?, ';
        }
        $sql = rtrim($sql, ', ');

        return $sql;
    }

    private function query()
    {
        $bindings = func_get_args();

        $sql = array_shift($bindings);
        if (count($bindings) == 1 AND is_array($bindings[0])) {
            $bindings = $bindings[0];
        }
        try {
            $query = $this->getConnection()->prepare($sql);

            foreach ($bindings as $key => $value) {
                $query->bindValue($key + 1, _e($value));
            }
            $query->execute();

            return $query;
        } catch (PDOException $e) {
            echo $sql;
            pre($this->bindings);
            die($e->getMessage());
        }
    }

    public function getConnection()
    {
        return static::$connection;
    }

    private function reset()
    {
        $this->data = [];
        $this->bindings = [];
        //$this->rows = 0;
        $this->limit = null;
        $this->offset = null;
        $this->table = null;
        $this->selects = [];
        $this->joins = [];
        $this->wheres = [];
        $this->havings = [];
        $this->orderby = [];
        $this->groupby = [];
        $this->bindings = [];
    }

    public function update($table = null)
    {
        if ($table) {
            $this->table($table);
        }
        $sql = 'UPDATE '.$this->table.' SET ';
        $sql .= $this->setFileds();

        if ($this->wheres) {
            $sql .= ' WHERE '.implode(' ', $this->wheres);
        }
        $this->query($sql, $this->bindings);
        $this->reset();

        return $this;
    }

    public function delete($table = null)
    {
        if ($table) {
            $this->table($table);
        }
        $sql = 'DELETE FROM '.$this->table;

        if ($this->wheres) {
            $sql .= ' WHERE '.implode(' ', $this->wheres);
        }
        $this->query($sql, $this->bindings);
        $this->reset();

        return $this;
    }

    public function getLastId()
    {
        return $this->lastId;
    }

    public function where()
    {

        $bindings = func_get_args();
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->wheres[] = $sql;

        return $this;
    }

    public function having()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->havings[] = $sql;

        return $this;
    }

    public function groupBy()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->groupby = $sql;

        return $this;
    }

    public function select($selects)
    {

        $selects = func_get_args();
        $this->selects = array_merge($this->selects, $selects);

        return $this;
    }

    public function join($join)
    {
        $this->joins[] = $join;

        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    public function fetch($table = null)
    {

        if ($table) {
            $this->table($table);
        }
        $sql = $this->fetchStmt();

        $r = $this->query($sql, $this->bindings)->fetch();
        $this->reset();

        return $r;
    }

    private function fetchStmt()
    {
        $sql = 'SELECT ';

        if ($this->selects) {
            $sql .= implode(',', $this->selects);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM '.$this->table.' ';

        if ($this->joins) {
            $sql .= implode(' ', $this->joins);
        }
        if ($this->wheres) {
            $sql .= ' WHERE '.implode(' ', $this->wheres);
        }
        if ($this->havings) {
            $sql .= ' HAVING '.implode(' ', $this->havings).' ';
        }
        if ($this->orderby) {
            $sql .= ' ORDER BY '.implode(' ', $this->orderby);
        }
        if ($this->limit) {
            $sql .= ' LIMIT '.$this->limit;
        }
        if ($this->offset) {
            $sql .= ' OFFSET '.$this->offset;
        }
        if ($this->groupby) {
            $sql .= ' GROUP BY '.implode(' ', $this->orderby);
        }

        return $sql;
    }

    public function fetchAll($table = null)
    {

        if ($table) {
            $this->table($table);
        }
        $sql = $this->fetchStmt();

        $q = $this->query($sql, $this->bindings);
        $r = $q->fetchAll();
        $this->rows = $q->rowCount();
        $this->reset();

        return $r;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function orderBy($orderBy, $sort = 'ASC')
    {

        $this->orderby = [$orderBy, $sort];

        return $this;
    }
}

<?php
namespace Database;

use PDO;
use PDOException;

class Database
{
    protected $host;
    protected $name;
    protected $user;
    protected $pass;
    protected $connection;
    protected $preparedQuery;

    public function __construct($host, $user, $pass, $name)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;

        $this->connect();
    }

    private function connect()
    {
        try {
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->name;
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function quote($string) {
        return $this->connection->quote($string);
    }

    public function execute()
    {
        return $this->preparedQuery->execute();
    }

    public function query($query)
    {
        $this->preparedQuery = $this->connection->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->preparedQuery->bindValue($param, $value, $type);
    }

    public function resultset($class = null)
    {
        $this->execute();
        if (isset($class) && is_string($class)) {
            return $this->preparedQuery->fetchAll(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class
            );
        } else {
            return $this->preparedQuery->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function single($class = null)
    {
        $this->execute();

        if (isset($class) && is_string($class)) {
            $this->preparedQuery->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
            return $this->preparedQuery->fetch();
        } else {
            return $this->preparedQuery->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function rowCount()
    {
        return $this->preparedQuery->rowCount();
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function close()
    {
        $this->connection = null;
    }
}

?>

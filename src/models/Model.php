<?php

/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 21:26
 */

namespace models;

use core\Database;

abstract class Model
{

    private $fields = [];

    public function getModelName()
    {
        $this->find();
        $this->loadFields();
        return substr(get_class($this), 7, strlen(get_class($this)));
    }

    public function find()
    {
        Database::getInstance();
    }


    public function query($query, $binds = [], $populate = true, $unique = false)
    {
        try {
            $p_sql = Database::getInstance()->prepare($query);
            foreach ($binds as $key => $value)
                $p_sql->bindValue(":" . $key, $value);
            $p_sql->execute();

            if ($populate)
                return $this->populate($p_sql->fetchAll(\PDO::FETCH_ASSOC), $unique);
            if ($unique)
                return $p_sql->fetch(\PDO::FETCH_ASSOC);
            return $p_sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }


    public function save($query, $binds = [])
    {
        try {
            $p_sql = Database::getInstance()->prepare($query);
            foreach ($binds as $key => $value)
                $p_sql->bindValue(":" . $key, $value);
            return ($p_sql->execute());
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }


    public function get($query, $binds = [], $populate = true)
    {
        return $this->query($query, $binds, $populate, true);
    }

    public abstract function populate($row);


    private function loadFields()
    {
        $api = new \ReflectionClass(get_class($this));
        foreach ($api->getProperties() as $property) {
            $this->fields[$property->getName()] = $property->getName();
        }
    }

    public function __toArray()
    {
        return call_user_func('get_object_vars', $this);
    }


}

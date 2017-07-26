<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 20/07/17
 * Time: 10:05
 */

namespace core;


/**
 * Class Database
 * @package core
 */
class Database
{
    /**
     * @var
     */
    public static $instance;


    /**
     *
     * Retorna a instância da base de dados
     * @return \PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new \PDO('mysql:host=' . getConfig('db_host') . ';dbname=' . getConfig('db_database'), getConfig('db_user'), getConfig('db_pass'),
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
        }
        return self::$instance;
    }
}
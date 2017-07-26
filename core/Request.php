<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 23:43
 */

namespace core;


/**
 * Class Request
 * @package core
 */
class Request
{
    /**
     * @var
     */
    public static $controller;
    /**
     * @var
     */
    public static $action;
    /**
     * @var
     */
    public static $view;
    /**
     * @var
     */
    public static $template;
    /**
     * @var
     */
    public static $components;
    /**
     * @var null
     */
    private static $_instance = null;
    /**
     * @var array
     */
    private static $view_vars = [];


    /**
     * @param mixed $controller
     */
    public static function setController($controller)
    {
        self::$controller = $controller;
    }

    /**
     * @param mixed $action
     */
    public static function setAction($action)
    {
        self::$action = $action;
    }

    /**
     * @return mixed
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * @param mixed $view
     */
    public static function setView($view)
    {
        self::$view = $view;
    }

    /**
     * @return mixed
     */
    public static function getView()
    {
        return self::$view;
    }


    /**
     * @return this
     */
    public static function getRequest()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * @param mixed $template
     */
    public static function setTemplate($template)
    {
        self::$template = $template;
    }

    /**
     * @param null $instance
     */
    public static function setInstance($instance)
    {
        self::$_instance = $instance;
    }

    /**
     * @return mixed
     */
    public static function getTemplate()
    {
        return getConfig('path_template') . self::$template;
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        return self::$_instance;
    }

    /**
     * @param array $view_vars
     */
    public static function setViewVars($view_vars)
    {
        self::$view_vars = array_merge($view_vars, self::$view_vars);
    }

    /**
     * @param null $index
     * @return array
     */
    public static function getViewVars($index = null)
    {
        if ($index == null)
            return self::$view_vars;
        return accessArray(self::$view_vars, $index);
    }

    /**
     * @param mixed $components
     */
    public static function setComponents($components)
    {
        self::$components = $components;
    }

    /**
     * @param mixed $components
     */
    public static function setComponent($component_key, $component_value)
    {
        self::$components[$component_key] = $component_value;
    }

    /**
     * @return mixed
     */
    public static function getComponent($index)
    {
        if (self::$components == null)
            return null;
        return self::$components[$index];
    }


    /**
     * @return mixed
     */
    public static function getComponents()
    {
        if (self::$components == null)
            self::$components = [];
        return self::$components;
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function getData($index = null)
    {
        if ($index == null)
            return $_POST;
        return accessArray($_POST, $index);
    }


    /**
     * @return mixed
     */
    public static function here()
    {
        $here = $_SERVER['REQUEST_URI'];
        $here = explode('?', $here);
        return $here[0];
    }


    /**
     * @param $url
     */
    public static function redirect($url)
    {
        header("location: " . $url);
    }

}
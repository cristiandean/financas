<?php

/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 21:25
 */

namespace controllers;

use core\Core;

/**
 * Class Controller
 * @package controllers
 */
class Controller extends Core
{
    /**
     * @var $model : Model referente ao controller em questão
     */
    public $model;


    /**
     * Controller constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->init();
        $this->loadModel();
    }

    /**
     * Classe chamada após inicializar o controller
     */
    public function init()
    {
    }

    /**
     * @return object
     */
    public function getModel()
    {
        if ($this->model != null)
            return $this->model;
        $this->loadModel();
        return $this->model;
    }


    /**
     * Carrega o model
     */
    private function loadModel()
    {
        $model = substr(get_class($this), 12, -10);
        $item = new \ReflectionClass('models\\' . $model);
        $this->model = $item->newInstance();
    }

    /**
     * Seta as variáveis da view
     * @param $arg
     */
    public function set($arg){
        $this->request->setViewVars($arg);
    }

    /**
     * Retorna o valor de certa variável da view
     * @param $index
     * @return mixed
     */
    public function get($index){
        return $this->request->getViewVars($index);
    }

    /**
     * Renderiza $vars no formato JSON
     * @param $vars
     */
    public function renderJson($vars){
        header('Content-Type: application/json');
        echo json_encode($vars);
        exit;
    }
}
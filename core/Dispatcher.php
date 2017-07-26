<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 20/07/17
 * Time: 08:57
 */

namespace core;


/**
 * Class Dispatcher
 * @package core
 */
class Dispatcher extends Core
{


    /**
     *Carrega o Dispatcher
     */
    public function load()
    {
        call_user_func([$this->request->getController(), $this->request->getAction()]);
        require $this->request->getTemplate();
    }

    /**
     * Retorna o controller
     * @return mixed
     */
    public function getController()
    {
        return $this->request->getController();
    }

    /**
     * Retorna o Model
     * @return mixed
     */
    public function getModel()
    {
        return $this->request->getController()->getModel();
    }

    /**
     * Renderiza a view
     */
    public function render()
    {
        require $this->request->getView();
    }


    /**
     *
     */
    public function init()
    {
    }
}
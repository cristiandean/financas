<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 22:42

 * @property \core\Request $request
 *
 * Classe de núcleo
 */

namespace core;


abstract class Core
{
    public $request;


    function __construct()
    {
        $this->request = Request::getRequest();
        $this->init();
    }

    public abstract function init();
}
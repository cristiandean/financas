<?php

/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 21:32
 */

namespace controllers;


/**
 * Class UsersController
 * @package controllers
 */
class UsersController extends Controller
{

    /**
     *
     */
    function init()
    {
    }

    /**
     *
     */
    function index()
    {
        setConfig('title_page', 'Listar Usuários');
    }

    /**
     *
     */
    function login()
    {
        $this->request->setTemplate('login.ctp');
        setConfig('title_page', 'Login');
    }


    /**
     * @return mixed
     */
    function logout()
    {
        return $this->request->redirect($this->request->getComponent('Auth')->logOut());
    }
}
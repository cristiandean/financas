<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 21/07/17
 * Time: 09:54
 * @property \core\Request $request
 * Componente de autenticação de Usuários
 */

namespace components;


use core\Core;
use models\Users;

/**
 * Class AuthComponent
 * @package components
 */
class AuthComponent extends Core
{

    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $userModel;

    /**
     *
     */
    function init()
    {
        $this->userModel = new Users();
        if ($this->getUser() == null)
            $this->login();
        else if ($this->request->here() == getConfig('login_page'))
            $this->request->redirect(getConfig('main_page'));
    }

    /**
     * @return null
     */
    public function logOut()
    {
        $this->user = null;
        $this->request->getComponent('Session')->destroy();
        return getConfig('login_page');
    }

    /**
     * Método responsável por retornar o usuário
     * @return mixed
     */
    public function getUser()
    {
        if ($this->user == null)
            $this->user = $this->request->getComponent('Session')->read('Auth.User');
        return $this->user;
    }


    /**
     *
     * Método Responsável por setar o usuário
     * @param $user
     */
    public function setUser($user)
    {
        $this->request->getComponent('Session')->set('Auth', ['User' => $user]);
        $this->user = $user;

    }

    /**
     * Método responsável por checar se o usuário está logado ou logá-lo
     */
    public function login()
    {
        if ($this->request->here() == getConfig('login_page') && $this->request->getData('username') === null && $this->request->getData('password') === null)
            return;

        if ($this->request->here() !== getConfig('login_page') && $this->getUser() == null)
            return $this->request->redirect(getConfig('login_page'));

        if ($this->request->here() === getConfig('login_page') && $this->request->getData('username') !== null && $this->request->getData('password') !== null) {
            $user = $this->userModel->get(
                'SELECT * FROM Users WHERE username LIKE :username AND password LIKE :password',
                ['username' => $this->request->getData('username'), 'password' => $this->hashPassword($this->request->getData('password'))],
                true);
            if ($user) {
                $this->setUser($user);
                return $this->request->redirect(getConfig('main_page'));
            }
        }
    }


    /**
     * @param $password
     * @return string
     */
    private function hashPassword($password)
    {
        return hash('sha256', $password);
    }

}
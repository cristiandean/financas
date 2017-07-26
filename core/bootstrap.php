<?php
session_start();
require 'core/config.php';
require 'core/func.php';

/**
 * Função responsável por carregar dinamicamente todas as classes
 * @param $classe : namespace\Classe que será carregada dinamicamente
 */

function __autoload($classe)
{

    $path = '';
    if (startsWith($classe, 'controllers\\'))
        $path = getConfig('path_controller') . substr($classe, 12, strlen($classe)) . '.php';
    else if (startsWith($classe, 'models\\'))
        $path = getConfig('path_model') . substr($classe, 7, strlen($classe)) . '.php';
    else if (startsWith($classe, 'exceptions\\'))
        $path = getConfig('path_exceptions') . substr($classe, 11, strlen($classe)) . '.php';
    else if (startsWith($classe, 'components\\'))
        $path = getConfig('path_components') . substr($classe, 11, strlen($classe)) . '.php';
    else if (startsWith($classe, 'core\\'))
        $path = getConfig('path_core') . substr($classe, 5, strlen($classe)) . '.php';
    if (file_exists($path))
        return include_once $path;
    throw new \exceptions\ClassNotFoundException('Não foi possível carregar a classe: ' . $classe);
}

/**
 * Função responsável por retornar a classe de requisição
 * @return \core\this
 */
function getRequest()
{
    return \core\Request::getRequest();
}

/**
 * Função responsável por carregar o controller
 */
function loadController()
{
    $controller = getController();
    $controller = new \ReflectionClass('controllers\\' . $controller . 'Controller');
    getRequest()->setController($controller->newInstance());
}

/**
 * Função responsável por carregar a action / view / template
 */
function loadAction()
{
    getRequest()->setAction(getAction());
    getRequest()->setView(getConfig('path_view') . \core\Request::getController()->getModel()->getModelName() . '/' . \core\Request::getAction() . '.ctp');
    getRequest()->setTemplate('default.ctp');
}

/**
 * * Função responsável por carregar os componentes
 * @param array $components
 */
function loadComponents($components = [])
{
    foreach ($components as $component){
        getRequest()->setComponent($component, (new \ReflectionClass('components\\' . $component . 'Component'))->newInstance());
    }
}

/**
 ** Função responsável por inicializar o bootstrap
 */
function bootstrap()
{
    loadComponents(['Session', 'Auth']);
    loadController();
    loadAction();
    $dispatcher = new \core\Dispatcher();
    $dispatcher->load();
}


/**
* Inicialização do bootstrap
*/
bootstrap();
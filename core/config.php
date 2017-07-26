<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 19/07/17
 * Time: 20:36
 *
 * Classe de configuração
 */
$_CONFIG['title_site'] = 'Sistema Financeiro';
$_CONFIG['title_page'] = 'Administração';

$_CONFIG['path_root'] = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
$_CONFIG['path_controller'] = 'src/controllers/';
$_CONFIG['path_model'] = 'src/models/';
$_CONFIG['path_core'] = 'core/';
$_CONFIG['path_view'] = 'src/views/';
$_CONFIG['path_exceptions'] = 'core/exceptions/';
$_CONFIG['path_components'] = 'core/components/';
$_CONFIG['path_template'] = 'src/Template/';


$_CONFIG['default_controller'] = 'Contas';
$_CONFIG['default_action'] = 'index';


$_CONFIG['db_host'] = 'localhost';
$_CONFIG['db_user'] = 'root';
$_CONFIG['db_pass'] = '';
$_CONFIG['db_database'] = 'financas';

$_CONFIG['login_page'] = '/Users/login';
$_CONFIG['main_page'] = '/Contas/home';
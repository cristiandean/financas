<?php

/**
 * Função responsável por retornar o conteúdo de $var de forma identada
 * @param $var
 * @return void
 */
function pr($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

/**
 * Debuga uma variável
 * @param $var
 */
function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

/**
 * Função responsável por verificar se a string $needle está contida no fim da string $haystack
 * @param $haystack
 * @param $needle
 * @return bool
 */
function endsWith($haystack, $needle)
{
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

/**
 * Função responsável por verificar se a string $needle está contida no fim da string $haystack
 * @param $haystack
 * @param $needle
 * @return bool
 */
function startsWith($haystack, $needle)
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}


/**
 * @param null $config_name
 * @return null
 */
function getConfig($config_name = null)
{
    global $_CONFIG;
    if ($config_name == null)
        return $_CONFIG;
    if (isset($_CONFIG[$config_name]))
        return $_CONFIG[$config_name];
    return null;

}

/**
 * @param $config_name
 * @param $config_value
 */
function setConfig($config_name, $config_value)
{
    global $_CONFIG;
    $_CONFIG[$config_name] = $config_value;

}

/**
 * @return null
 */
function getController()
{
    if (getUrlPosition(0) != null)
        return getUrlPosition(0);
    return getConfig('default_controller');
}

/**
 * @return null
 */
function getAction()
{
    if (getUrlPosition(1) != null)
        return getUrlPosition(1);
    return getConfig('default_action');
}


/**
 * @param $position
 * @return null
 */
function getUrlPosition($position)
{
    $url = isset($_GET['url']) ? $_GET['url'] : '';
    $url = explode('/', $url);
    if (count($url) > $position)
        return $url[$position];
    return null;
}

/**
 * Verifica se a string está serializada
 * @param $data
 * @return bool
 */
function isSerialized($data)
{
    return (is_string($data) && preg_match("#^((N;)|((a|O|s):[0-9]+:.*[;}])|((b|i|d):[0-9.E-]+;))$#um", $data));
}



/**
 * Converte entradas monetária para float
 * @param $str
 * @return float
 */
function moneyToFloat($str)
{
    return (float)str_replace(',', '.', preg_replace("/[^0-9,]/", "", $str));
}

/**
 * Acessa dinamicamente o array através de pontos (.)
 * @param $context
 * @param $key
 * @return mixed|null
 */
function accessArray(&$context, $key)
{
    $pieces = explode('.', $key);
    foreach ($pieces as $piece) {
        if (!is_array($context) || !array_key_exists($piece, $context)) {
            return null;
        }
        $context = &$context[$piece];
        if (isSerialized($context))
            $context = unserialize($context);
    }
    return $context;
}

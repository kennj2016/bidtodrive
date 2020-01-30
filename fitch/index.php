<?php

try {

    require_once __DIR__ . '/vendor/autoload.php';

    if (!@include_once('settings_servers.php')) {
        throw new FatalException('Failed to load servers configuration file');
    }

    error_reporting(FJF_SERVER == 'live' ? 0 : E_ALL);
    ini_set('display_errors', FJF_SERVER == 'live' ? '0' : '1');

    ini_set('date.timezone', 'US/Eastern');
    date_default_timezone_set('US/Eastern');

//    if (!ini_get('date.timezone')) {
//        ini_set('date.timezone', 'America/Chicago');
//        date_default_timezone_set('America/Chicago');
//    }

    /**
     * Disable magic_quotes_gpc
     */
    if (get_magic_quotes_gpc()) {
        $_GET = array_stripslashes($_GET);
        $_POST = array_stripslashes($_POST);
        $_COOKIE = array_stripslashes($_COOKIE);
        $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
    }

    /**
     * Request variables
     */
    $REQUEST_CONTAINER = $_REQUEST;
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $REQUEST_CONTAINER = $_GET;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (is_array($_GET) && count($_GET) > 0) {
            $_POST = array_merge($_GET, $_POST);
        }
        $REQUEST_CONTAINER = &$_POST;
    }

    define('FJF_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/fitch');
    define('WEB_CONTROLLER', '/fitch/index.php');

    /**
     * Include FJF configuration files
     */
    if (!@include_once(FJF_ROOT . '/settings.php')) {
        throw new FatalException('Failed to load application configuration file');
    }

    if (!is_array($WEB_APPLICATION_CONFIG)) {
        throw new FatalException('Invalid Configuration File: WEB_APPLICATION_CONFIG is null');
    }

    if (!@include_once(FJF_ROOT . '/settings_db.php')) {
        throw new FatalException('Failed to load DB configuration file');
    }

    /**
     * Include Web Application Base Class - Fitch and Josephine Framework (FJF)
     */
    if (!@include_once($WEB_APPLICATION_CONFIG["lib_path"] . "/FJF_BASE.php")) {
        throw new FatalException('Failed to include Web Application Base class');
    }

    if (!@include_once($WEB_APPLICATION_CONFIG["lib_path"] . "/FJF_BASE_RICH.php")) {
        throw new FatalException('Failed to include Web Application Base Rich class');
    }

    /**
     * Include Smarty Template Engine
     */
    if (!@include_once($WEB_APPLICATION_CONFIG["smarty_path"] . "/Smarty.class.php")) {
        throw new FatalException('Failed to include Smarty library');
    }

    /**
     * Global Redirection (fixing missing trailing slashes in URLs)
     */
    FJF_BASE::global_redirect();

    /**
     * Instantiate & configure Smarty
     */
    $smartyEngine = new Smarty();
    if ($WEB_APPLICATION_CONFIG["debug_mode"]) {
        $smartyEngine->compile_check = true;
        $smartyEngine->force_compile = true;
    } else {
        $smartyEngine->compile_check = false;
        $smartyEngine->force_compile = false;
    }
    $smartyEngine->debugging = false;
    $smartyEngine->template_dir = $WEB_APPLICATION_CONFIG["templates_path"] . "/";
    $smartyEngine->compile_dir = $WEB_APPLICATION_CONFIG["smarty_compile_path"];
    $smartyEngine->assign_by_ref("web_config", $WEB_APPLICATION_CONFIG);


    /**
     * Include Additional FJF functions for Smarty Template Engine
     */
    if (!@include_once($WEB_APPLICATION_CONFIG["lib_path"] . "/FJF_SMARTY_FUNCTIONS.php")) {
        throw new FatalException('Failed to include Additional FJF functions for Smarty');
    }

    /**
     * Request command
     */
    $REQUEST_CMD = isset($REQUEST_CONTAINER['cmd']) ? strtolower($REQUEST_CONTAINER['cmd']) : null;
    if (!$REQUEST_CMD) {
        $REQUEST_CMD = $WEB_APPLICATION_CONFIG["default_cmd"];
    }

    FJF_BASE::log("Request: [" . $_SERVER['REQUEST_METHOD'] . "," . $REQUEST_CMD . "]", "controller");

    /**
     * Load Command Definition Based on request
     */
    FJF_BASE::process_request($REQUEST_CMD);

} catch (FatalException $e) {

    exit($e);

} catch (Exception $e) {

    FJF_BASE::log("Unidentified exception: " . $e->getMessage(), "controller");

}

/**
 * Stripslashes multi-dimensional array
 * @param mixed $value
 * @return mixed
 */
function array_stripslashes($value)
{
    if (is_array($value)) {
        $result = array();
        foreach ($value as $k => $v) {
            $result[stripslashes($k)] = array_stripslashes($v);
        }
        return $result;
    } elseif (is_string($value)) {
        return stripslashes($value);
    }
    return $value;
}

/**
 * Prints out variables
 * @param mixed $var
 * @param mixed $exit
 * @return boolean
 */
function test($var = null, $exit = 1)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if ($exit) {
        exit;
    }
    return true;
}


/**
 * Custom exception class to handle critical exceptions
 */
class FatalException extends Exception
{

    public function __toString()
    {
        return "<h1>Framework Error: " . $this->message . "</h1>";
    }

}

?>
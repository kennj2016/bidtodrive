<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class BrowserFallback extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        return $this->displayTemplate("browser_fallback.tpl", array());
    }

}

?>
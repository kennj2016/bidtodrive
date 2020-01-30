<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class About extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        $this->pageModel->loadSettings("about");
        $settings = $this->pageModel->getSettings();

        if (is_object($settings) && $settings->buckets != "") {
            $settings->buckets = json_decode($settings->buckets);
        }

        if (is_object($settings) && $settings->steps != "") {
            $settings->steps = json_decode($settings->steps);
        }

        return $this->displayTemplate("about.tpl", array(
            "settings" => $settings
        ));
    }

}

?>
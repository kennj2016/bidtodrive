<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");

class AdminSiteMedia extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Site Media');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $folders = SiteMediaModel::getFolders();

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/images_model.php");

        return $this->displayTemplate("admin_site_media.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "folders" => $folders
        ));
    }

}

?>
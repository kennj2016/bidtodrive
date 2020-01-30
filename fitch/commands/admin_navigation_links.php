<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminNavigationLinks extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = isset($_POST["action"]) ? trim($_POST["action"]) : "";
            $fields = isset($_POST["fields"]) && is_array($_POST["fields"]) ? array_map("trim", $_POST["fields"]) : array();

            if ($action == "popup") {
                echo $this->fetchTemplate("admin_navigation_links_edit.tpl", array("fields" => $fields));
            }
        }//POST

        return false;
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminRobotsEditor extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Robots.txt Editor');

    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $fname = $_SERVER["DOCUMENT_ROOT"] . "/robots.txt";

        $record = @file_get_contents($fname);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record = isset($_POST["text"]) ? trim($_POST["text"]) : "";
            if (!@file_put_contents($fname, $record)) {
                $hasError = true;
                $status = "An error occurred while saving file.";
            } else {
                $status = "File was saved successfully.";
            }
        }//POST

        $templateParams = array(
            "status" => $status,
            "has_error" => $hasError,
            "header" => $header,
            "record" => $record
        );

        $this->displayTemplate("admin_robots_editor.tpl", $templateParams);

        return true;
    }

}

?>
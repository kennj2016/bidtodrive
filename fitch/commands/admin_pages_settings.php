<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminPagesSettings extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");
        $editor = new AdminSiteDataEditor('pages_settings');

        $record = $editor->loadRecord();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
            $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
            $record->meta_title = isset($_POST["meta_title"]) ? trim($_POST["meta_title"]) : "";
            $record->meta_keywords = isset($_POST["meta_keywords"]) ? trim($_POST["meta_keywords"]) : "";
            $record->meta_description = isset($_POST["meta_description"]) ? trim($_POST["meta_description"]) : "";

            if (!$hasError) {
                if ($editor->saveRecord()) FJF_BASE::redirect("/admin/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                    $status .= "\n" . FJF_BASE::db_error();
                }
            }
        }//POST

        $header["title"] = "Settings: " . ucfirst(str_replace(array("_", "-"), " ", $_GET['id']));

        return $this->displayTemplate("admin_pages_settings.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
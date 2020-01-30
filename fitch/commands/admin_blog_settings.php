<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminBlogSettings extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Settings: Blog');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");
        $editor = new AdminSiteDataEditor('pages_settings', 'blog');

        $record = $editor->loadRecord();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
            $record->subtitle = isset($_POST["subtitle"]) ? trim($_POST["subtitle"]) : "";
            $record->hero_image = isset($_POST["hero_image"]) ? trim($_POST["hero_image"]) : "";
            $record->breadcrumbs = isset($_POST["breadcrumbs"]) ? trim($_POST["breadcrumbs"]) : "";
            $record->meta_title = isset($_POST["meta_title"]) ? trim($_POST["meta_title"]) : "";
            $record->meta_keywords = isset($_POST["meta_keywords"]) ? trim($_POST["meta_keywords"]) : "";
            $record->meta_description = isset($_POST["meta_description"]) ? trim($_POST["meta_description"]) : "";

            if (!$hasError) {
                if ($editor->saveRecord()) {
                    $status = "Data was saved successfully.";
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }//POST

        return $this->displayTemplate("admin_blog_settings.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
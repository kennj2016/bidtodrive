<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminContactSettingsAutosave extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        $data = array();
        $hasError = false;
        $status = "";

        if (!$this->sessionModel->hasAdminPermissions()) {
            $hasError = true;
            $status = "Access denied.";
        } else {
            $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'contact');

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                    $record->subtitle = isset($_POST["subtitle"]) ? trim($_POST["subtitle"]) : "";
                    $record->hero_image = isset($_POST["hero_image"]) ? trim($_POST["hero_image"]) : "";
                    $record->address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
                    $record->city = isset($_POST["city"]) ? trim($_POST["city"]) : "";
                    $record->state = isset($_POST["state"]) ? trim($_POST["state"]) : "";
                    $record->zip = isset($_POST["zip"]) ? trim($_POST["zip"]) : "";
                    $record->phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
                    $record->form_intro = isset($_POST["form_intro"]) ? trim($_POST["form_intro"]) : "";
                    $record->form_submissions = isset($_POST["form_submissions"]) ? trim($_POST["form_submissions"]) : "";

                    $record->meta_title = isset($_POST["meta_title"]) ? trim($_POST["meta_title"]) : "";
                    $record->meta_keywords = isset($_POST["meta_keywords"]) ? trim($_POST["meta_keywords"]) : "";
                    $record->meta_description = isset($_POST["meta_description"]) ? trim($_POST["meta_description"]) : "";

                    if ($revision = $editor->autosave()) {
                        $data['revision'] = $revision;
                    } else {
                        $hasError = true;
                        $status = "Autosave was failed.";
                    }

                } else {

                    $data['revisions'] = $editor->getRevisions();

                }
            }
        }

        exit(json_encode(
            array('has_error' => $hasError, 'status' => $status) + $data
        ));
    }

}

?>
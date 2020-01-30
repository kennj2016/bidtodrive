<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminContactSettings extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Contact: Settings');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");
        //include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");

        $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'contact');
        $record = $editor->loadRecord();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

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
            }

            if (!$hasError) {
                if ($editor->$method()) {
                    $status = "Data was saved successfully.";
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }//POST

        return $this->displayTemplate("admin_contact_settings.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
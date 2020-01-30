<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminRegistrationSettingsAutosave extends FJF_CMD
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
            $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'registration');

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $record->register_intro = isset($_POST["register_intro"]) ? trim($_POST["register_intro"]) : "";
                    $record->seller_registration_confirmation_message = isset($_POST["seller_registration_confirmation_message"]) ? trim($_POST["seller_registration_confirmation_message"]) : "";
                    $record->buyer_registration_confirmation_message = isset($_POST["buyer_registration_confirmation_message"]) ? trim($_POST["buyer_registration_confirmation_message"]) : "";

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
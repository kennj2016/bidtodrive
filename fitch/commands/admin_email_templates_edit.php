<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminEmailTemplatesEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Email Templates');
        $this->setToolTitleSingular('Email Template');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'email_templates',
            'title_field' => 'name',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/email_templates/");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
                $record->subject = isset($_POST["subject"]) ? trim($_POST["subject"]) : "";
                $record->body = isset($_POST["body"]) ? trim($_POST["body"]) : "";
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                if ($messages = $editor->validate(array(
                    'name' => array('label' => 'Name', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }

            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/email_templates/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('email_templates', 'email templates');

        return $this->displayTemplate("admin_email_templates_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
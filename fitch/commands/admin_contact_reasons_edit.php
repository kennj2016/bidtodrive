<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminContactReasonsEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Contact Reasons');
        $this->setToolTitleSingular('Contact Reasons');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'contact_reasons',
            'title_field' => 'title',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/contact_reasons/");
        $users = FJF_BASE_RICH::getRecords("users");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                if ($messages = $editor->validate(array(
                    'title' => array('label' => 'Title', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }

            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/contact_reasons/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('contact_reasons', 'contact reasons');

        return $this->displayTemplate("admin_contact_reasons_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
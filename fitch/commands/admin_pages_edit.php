<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminPagesEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Pages');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/pages/";
        }

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'pages',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

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
                $record->body = isset($_POST["body"]) ? trim($_POST["body"]) : "";
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                if (!$record->title) {
                    $hasError = true;
                    $status .= "Title cannot be blank.\n";
                }

                $editor->autofillMetadata('title');
            }

            if (!$hasError) {
                if ($editor->$method()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/pages/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('pages');

        return $this->displayTemplate("admin_pages_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
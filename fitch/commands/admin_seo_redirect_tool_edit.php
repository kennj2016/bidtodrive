<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminSeoRedirectToolEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('301 Redirects');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/seo_redirect_tool/";
        }

        $editor = new AdminEditModel(array(
            'table' => 'seo_redirect'
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->old_url = isset($_POST["old_url"]) && $_POST["old_url"] ? trim($_POST["old_url"]) : "";
            $record->new_url = isset($_POST["new_url"]) && $_POST["new_url"] ? trim($_POST["new_url"]) : "";
            $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

            if (!$record->old_url) {
                $hasError = true;
                $status .= "old url can't be empty.\n";
            }

            if (!$record->new_url) {
                $hasError = true;
                $status .= "new url can't be empty.\n";
            }

            if (!$hasError) {
                if ($editor->saveRecord()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/seo_redirect_tool/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        if (isset($record->old_url))
            $record->title = $record->old_url;
        $this->setRecord($record);
        $this->addParentBreadCrumb('seo_redirect_tool');

        return $this->displayTemplate("admin_seo_redirect_tool_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
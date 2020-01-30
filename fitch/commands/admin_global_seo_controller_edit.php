<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminGlobalSeoControllerEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('SEO Settings');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/global_seo_controller/";
        }

        $editor = new AdminEditModel(array(
            'table' => 'global_seo_controller',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->text = isset($_POST["text"]) ? trim($_POST["text"]) : "";
            $record->url = isset($_POST["url"]) ? trim($_POST["url"]) : "";
            $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

            if (!$record->text) {
                $hasError = true;
                $status .= "text cannot be blank.\n";
            }

            if (!$record->url) {
                $hasError = true;
                $status .= "url cannot be blank.\n";
            }

            $editor->autofillMetadata();

            if (!$hasError) {
                if ($editor->saveRecord()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/global_seo_controller/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        if (isset($record->text)) {
            $record->title = $record->text;
        }
        $this->setRecord($record);
        $this->addParentBreadCrumb('global_seo_controller');

        return $this->displayTemplate("admin_global_seo_controller_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminHomepageSlideshowEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Homepage: Slideshow');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/homepage/slideshow/";
        }

        $editor = new AdminEditModel(array(
            'table' => 'homepage_slideshow',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
            $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
            $record->image = isset($_POST["image"]) ? trim($_POST["image"]) : "";
            $record->url = isset($_POST["url"]) ? trim($_POST["url"]) : "";

            if ($messages = $editor->validate(array(
                'title' => array('required' => true),
                'image' => array('required' => true),
                'url' => array('format' => 'url')
            ))) {
                $hasError = true;
                $status = implode("\n", $messages);
            }

            if (!$hasError) {
                if ($record->status) FJF_BASE_RICH::updateRecords("homepage_slideshow", "status=0");
                if ($editor->saveRecord()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/homepage/slideshow/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('homepage/slideshow');

        return $this->displayTemplate("admin_homepage_slideshow_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
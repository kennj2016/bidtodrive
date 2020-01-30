<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminBlogCategoriesEditAutosave extends FJF_CMD
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
        } elseif (!isset($_GET['id']) || !trim($_GET['id'])) {
            $hasError = true;
            $status = "Invalid ID.";
        } else {
            $editor = new AdminEditRevisionsModel(array(
                'table' => 'blog_categories'
            ));

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                    $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                    $record->url_title = $editor->urlTitle($record->title);

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
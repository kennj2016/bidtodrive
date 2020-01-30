<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminBlogPostsEditAutosave extends FJF_CMD
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
                'table' => 'blog_posts'
            ));

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                    $record->image = isset($_POST["image"]) ? trim($_POST["image"]) : "";
                    $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                    $record->author_id = isset($_POST["author_id"]) && intval($_POST["author_id"]) ? intval($_POST["author_id"]) : $this->sessionModel->user->id;
                    $record->category_id = isset($_POST["category_id"]) && intval($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;
                    $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                    $record->datetime_publish = isset($_POST["datetime_publish"]) ? trim($_POST["datetime_publish"]) : '';
                    if ($record->datetime_publish) {
                        if ($record->datetime_publish = @strtotime($record->datetime_publish)) {
                            $record->datetime_publish = date("Y-m-d H:i:s", $record->datetime_publish);
                        }
                    }
                    if (!$record->datetime_publish) $record->datetime_publish = date("Y-m-d H:i:s");

                    $editor->autofillMetadata('title');

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
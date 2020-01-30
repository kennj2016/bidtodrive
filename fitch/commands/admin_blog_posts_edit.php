<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminBlogPostsEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Blog Posts');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/blog/posts/";
        }

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'blog_posts'
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

        $users = FJF_BASE_RICH::getRecords("users");
        $categories = FJF_BASE_RICH::getRecords("blog_categories");

        if (!isset($record->author_id) || !$record->author_id) $record->author_id = $this->sessionModel->user->id;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                $record->image = isset($_POST["image"]) ? trim($_POST["image"]) : "";
                $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                $record->category_id = isset($_POST["category_id"]) && intval($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;
                $record->author_id = isset($_POST["author_id"]) && intval($_POST["author_id"]) ? intval($_POST["author_id"]) : $this->sessionModel->user->id;
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                $record->datetime_publish = isset($_POST["datetime_publish"]) ? trim($_POST["datetime_publish"]) : '';
                if ($record->datetime_publish) {
                    if ($record->datetime_publish = @strtotime($record->datetime_publish)) {
                        $record->datetime_publish = date("Y-m-d H:i:s", $record->datetime_publish);
                    }
                }
                if (!$record->datetime_publish) $record->datetime_publish = date("Y-m-d H:i:s");

                if ($messages = $editor->validate(array(
                    'title' => array('label' => 'Title', 'required' => true),
                    'category_id' => array('label' => 'Category', 'required' => true),
                    'description' => array('label' => 'Description', 'required' => true),
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

                $editor->autofillMetadata('title');
            }

            if (!$hasError) {
                if ($editor->$method()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/blog/posts/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST


        $this->setRecord($record);
        $this->addParentBreadCrumb('blog/posts');

        return $this->displayTemplate("admin_blog_posts_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "users" => $users,
            "categories" => $categories
        ));
    }

}

?>
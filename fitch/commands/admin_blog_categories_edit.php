<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminBlogCategoriesEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Blog Categories');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/blog/categories/";
        }

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'blog_categories',
            'title_field' => 'name',
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
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                $record->url_title = $editor->urlTitle($record->title);

                if ($messages = $editor->validate(array(
                    'title' => array('label' => 'Title', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }

            if (!$hasError) {
                if ($editor->$method()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/blog/categories/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('blog/categories');

        return $this->displayTemplate("admin_blog_categories_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
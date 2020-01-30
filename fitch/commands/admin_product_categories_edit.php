<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminProductCategoriesEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Product Categories');
        $this->setToolTitleSingular('Product Category');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'product_categories',
            'title_field' => 'title',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/product_categories/");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

                if ($messages = $editor->validate(array(
                    'title' => array('label' => 'Title', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }
            /*
            echo "<pre>";
            print_r($editor->$method());
            exit;
            */
            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/product_categories/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('product_categories', 'product category');

        return $this->displayTemplate("admin_product_categories_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
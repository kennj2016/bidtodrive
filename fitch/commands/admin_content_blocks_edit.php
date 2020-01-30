<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminContentBlocksEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Content Blocks');
        $this->setToolTitleSingular('Content Block');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'auctions_content_blocks',
            'title_field' => 'title',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) {
            FJF_BASE::redirect("/admin/content_blocks/");
        } else {
            if (isset($record->payment_method) && $record->payment_method != "") {
                $CBpaymentMethods = explode(",", $record->payment_method);
            }
        }

        $users = FJF_BASE_RICH::getRecords("users");
        $paymentMethods = array(
            1 => "Check",
            2 => "Cash",
            3 => "Bank Check",
            4 => "Money Order",
            5 => "Wire Transfer"
        );
        $paymentMethodsField = new AdminAutocompleteField('payment_method', $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"], 'multiple');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                $record->type = isset($_POST["type"]) ? trim($_POST["type"]) : "";
                $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                $record->user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : 0;

                $record->payment_method = $paymentMethodsField->getValue();
                $record->pickup_window = isset($_POST["pickup_window"]) ? trim($_POST["pickup_window"]) : 0;
                $record->pickup_note = isset($_POST["pickup_note"]) ? trim($_POST["pickup_note"]) : "";

                if ($messages = $editor->validate(array(
                    'title' => array('label' => 'Title', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }

            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/content_blocks/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('content_blocks', 'content blocks');

        $users = FJF_BASE_RICH::getRecords("users", " user_type = 'Seller'", false, false, "id, name");
        if (isset($record->payment_method)) $paymentMethodsField->setValue($record->payment_method);

        return $this->displayTemplate("admin_content_blocks_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "users" => $users,
            "record" => $record,
            "payment_methods_field" => $paymentMethodsField
        ));
    }

}

?>
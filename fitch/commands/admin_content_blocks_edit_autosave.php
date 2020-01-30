<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminContentBlocksEditAutosave extends FJF_CMD
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
                'table' => 'auctions_content_blocks'
            ));

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                $paymentMethodsField = new AdminAutocompleteField('payment_method', $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"], 'multiple');
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                    $record->type = isset($_POST["type"]) ? trim($_POST["type"]) : "";
                    $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                    $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                    $record->user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : 0;

                    $record->payment_method = $paymentMethodsField->getValue();
                    $record->pickup_transporter = isset($_POST["pickup_transporter"]) ? trim($_POST["pickup_transporter"]) : "";
                    $record->pickup_address = isset($_POST["pickup_address"]) ? trim($_POST["pickup_address"]) : "";
                    $record->pickup_city = isset($_POST["pickup_city"]) ? trim($_POST["pickup_city"]) : "";
                    $record->pickup_state = isset($_POST["pickup_state"]) ? trim($_POST["pickup_state"]) : "";
                    $record->pickup_zip = isset($_POST["pickup_zip"]) ? trim($_POST["pickup_zip"]) : "";
                    $record->transporter_phone = isset($_POST["transporter_phone"]) ? trim($_POST["transporter_phone"]) : "";
                    $record->pickup_driver = isset($_POST["pickup_driver"]) ? trim($_POST["pickup_driver"]) : "";
                    $record->driver_phone = isset($_POST["driver_phone"]) ? trim($_POST["driver_phone"]) : "";
                    $record->pickup_window = isset($_POST["pickup_window"]) ? trim($_POST["pickup_window"]) : 0;
                    $record->pickup_note = isset($_POST["pickup_note"]) ? trim($_POST["pickup_note"]) : "";

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
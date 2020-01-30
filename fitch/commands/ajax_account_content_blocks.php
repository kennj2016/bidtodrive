<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AjaxAccountContentBlocks extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $result = array("has_error" => false, "success" => false, "status" => "", "id" => "");

        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = SessionModel::loggedUserID();
            $action = isset($_POST["action"]) ? trim($_POST["action"]) : "";
            if ($action == "save_term") {
                $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
                $editor = new AdminEditRevisionsModel(array(
                    'table' => 'auctions_content_blocks',
                    'title_field' => 'title',
                    'positions' => true,
                    'id' => $id
                ));
                $record = $editor->loadRecord();
                $record->title = isset($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "";
                $record->description = isset($_REQUEST["description"]) ? trim($_REQUEST["description"]) : "";
                $record->type = "Terms & Conditions";
                $record->status = 1;
                $record->user_id = $userID;
                if (!$record->title) {
                    $result["has_error"] = true;
                    $result["status"] .= "Title is missing.<br />";
                }
                if (!$record->description) {
                    $result["has_error"] = true;
                    $result["status"] .= "Terms & Conditions is missing.";
                }
                if (!$result["has_error"]) {
                    if ($editor->saveAndPublish()) {
                        $result["id"] = $record->id;

                        $result["success"] = true;
                        $result["status"] .= "Record was saved successfully.";
                    } else {
                        $result["has_error"] = true;
                        $result["status"] .= "An error occurred while saving record.\n";
                    }
                }
                echo json_encode($result);
                return false;
            } elseif ($action == "save_fee") {
                $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
                $editor = new AdminEditRevisionsModel(array(
                    'table' => 'auctions_content_blocks',
                    'title_field' => 'title',
                    'positions' => true,
                    'id' => $id
                ));
                $record = $editor->loadRecord();
                $record->title = isset($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "";
                $record->description = isset($_REQUEST["description"]) ? trim($_REQUEST["description"]) : "";
                $record->type = "Additional Fees";
                $record->status = 1;
                $record->user_id = $userID;
                if (!$record->title) {
                    $result["has_error"] = true;
                    $result["status"] .= "Title is missing.<br />";
                }
                if (!$record->description) {
                    $result["has_error"] = true;
                    $result["status"] .= "Additional Fees is missing.\n";
                }
                if (!$result["has_error"]) {
                    if ($editor->saveAndPublish()) {
                        $result["id"] = $record->id;

                        $result["success"] = true;
                        $result["status"] .= "Record was saved successfully.";
                    } else {
                        $result["has_error"] = true;
                        $result["status"] .= "An error occurred while saving record.\n";
                    }
                }
            } elseif ($action == "payment_pickup") {
                $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
                $editor = new AdminEditRevisionsModel(array(
                    'table' => 'auctions_content_blocks',
                    'title_field' => 'title',
                    'positions' => true,
                    'id' => $id
                ));
                $record = $editor->loadRecord();
                $record->title = isset($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "";
                $record->payment_method = isset($_REQUEST["payment_method"]) ? $_REQUEST["payment_method"] : "";
                if ($record->payment_method != "") {
                    $record->payment_method = implode(",", $record->payment_method);
                } else {
                    $record->payment_method = "";
                }

                $record->pickup_window = isset($_REQUEST["pickup_window"]) ? intval($_REQUEST["pickup_window"]) : 0;
                $record->pickup_note = isset($_REQUEST["pickup_note"]) ? trim($_REQUEST["pickup_note"]) : "";
                $record->type = "Payment/Pickup";
                $record->status = 1;
                $record->user_id = $userID;
                if (!$record->title) {
                    $result["has_error"] = true;
                    $result["status"] .= "Title is missing.<br />";
                }
                if (!$record->payment_method) {
                    $result["has_error"] = true;
                    $result["status"] .= "Payment Method is missing.<br />";
                }
                if (!$record->pickup_window) {
                    $result["has_error"] = true;
                    $result["status"] .= "Pickup Window is missing.<br />";
                }
                if (!$record->pickup_note) {
                    $result["has_error"] = true;
                    $result["status"] .= "Pickup Note is missing.<br />";
                }
                if (!$result["has_error"]) {
                    if ($editor->saveAndPublish()) {
                        $result["id"] = $record->id;

                        $result["success"] = true;
                        $result["status"] .= "Record was saved successfully.";
                    } else {
                        $result["has_error"] = true;
                        $result["status"] .= "An error occurred while saving record4.\n";
                    }
                }
            } elseif ($action == "delete_term") {
                $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
                if ($id) {
                    FJF_BASE_RICH::deleteRecords("auctions_content_blocks", "id=" . $id);
                    FJF_BASE_RICH::deleteRecords("auctions_content_blocks_revisions", "id=" . $id);

                    $result["success"] = true;
                    $result["status"] .= "Record was deleted successfully.";
                } else {
                    $result["has_error"] = true;
                    $result["status"] .= "An error occurred while deleting record.";
                }
            }
        }

        exit(json_encode($result));
    }
}
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AjaxAccountNotifications extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $error = "";
        $status = "";

        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $uid = SessionModel::getUserUID();
            $recordID = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
            $notificationInfo = FJF_BASE_RICH::getRecord("notifications", "id = 'RECORD_ID' AND uid = 'UID'", array("RECORD_ID" => $recordID, "UID" => $uid));

            if ($notificationInfo) {
                $fields["id"] = $recordID;
                $fields["is_read"] = 1;

                $updateResult = FJF_BASE_RICH::updateRecord("notifications", $fields, "id");
                if ($updateResult) {
                    $status = "Success";
                }
            }
        }

        $data["error"] = $error;
        $data["status"] = $status;

        exit(json_encode($data));
    }
}
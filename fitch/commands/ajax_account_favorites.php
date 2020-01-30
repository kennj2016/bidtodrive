<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AjaxAccountFavorites extends FJF_CMD
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
            $action = isset($_POST["action"]) ? trim($_POST["action"]) : "";
            $userID = SessionModel::loggedUserID();
            if ($action == "remove") {
                $recordID = isset($_POST["rec_id"]) ? intval($_POST["rec_id"]) : 0;
                $favoriteInfo = FJF_BASE_RICH::getRecord("users_favorites", "record_id = 'RECORD_ID' AND user_id = 'USER_ID'", array("RECORD_ID" => $recordID, "USER_ID" => $userID));
                if (is_object($favoriteInfo)) {
                    $deleteResult = FJF_BASE_RICH::deleteRecord("users_favorites", $favoriteInfo->id, "id");
                    if ($deleteResult) {
                        $status = "Success";
                    }
                }
            } elseif ($action == "add") {
                $recordID = isset($_POST["rec_id"]) ? intval($_POST["rec_id"]) : 0;
                $favoriteInfo = FJF_BASE_RICH::getRecord("users_favorites", "record_id = 'RECORD_ID' AND user_id = 'USER_ID'", array("RECORD_ID" => $recordID, "USER_ID" => $userID));
                if ($favoriteInfo == null) {
                    $fields["user_id"] = $userID;
                    $fields["record_id"] = $recordID;
                    $fields["date"] = date("Y-m-d H:i:s");
                    $insertResult = FJF_BASE_RICH::insertRecord("users_favorites", $fields, "id");
                    if ($insertResult) {
                        $status = "Success";
                    }
                }
            }
        }

        $data["error"] = $error;
        $data["status"] = $status;

        exit(json_encode($data));
    }
}
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AjaxUsersSwitcher extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        $data = array();
        if ($this->isAjax() && SessionModel::isAdmin()) {
            $action = (isset($_GET["action"])) ? trim($_GET["action"]) : "";
            if ($action == "get_users") {
                $term = (isset($_REQUEST["term"])) ? trim($_REQUEST["term"]) : "";
                $users = FJF_BASE_RICH::getRecords("users", "status = 1 AND is_admin = 0 AND name LIKE '%TERM%'", array("TERM" => $term));

                $data = array();
                if ($users) {
                    foreach ($users as $user) {
                        $recordObj = new stdClass();
                        $recordObj->id = $user->id;
                        $recordObj->label = $user->name;
                        $data[] = $recordObj;
                        unset($recordObj);
                    }
                }

                exit(json_encode($data));
            }

            $data["user_type"] = (isset($_COOKIE["user_type"]) && trim($_COOKIE["user_type"]) == "user") ? "user" : "admin";
            $data["cc_user_id"] = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;

            $data["user_info"] = null;
            if ($data["cc_user_id"]) {
                $userInfo = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array("USER_ID" => $data["cc_user_id"]));
                $data["user_name"] = (is_object($userInfo)) ? $userInfo->name : "";
            }
        }

        exit(json_encode($data));
    }
}

?>
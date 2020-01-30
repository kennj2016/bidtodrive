<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AjaxAccountSellerFavorites extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $data["error"] = "";
            $data["status"] = "";
            $userID = SessionModel::loggedUserID();
            $action = isset($_POST["action"]) ? trim($_POST["action"]) : "";
            $sellerID = isset($_POST["seller_id"]) ? intval($_POST["seller_id"]) : 0;
            if ($action == "remove") {
                $favoriteInfo = FJF_BASE_RICH::getRecord("users_sellers_favorites", "seller_id = 'SELLER_ID' AND user_id = 'USER_ID'", array("SELLER_ID" => $sellerID, "USER_ID" => $userID));
                if (is_object($favoriteInfo)) {
                    $deleteResult = FJF_BASE_RICH::deleteRecord("users_sellers_favorites", $favoriteInfo->id, "id");
                    if ($deleteResult) {
                        $data["status"] = "Success";
                    }
                }
            } elseif ($action == "add") {
                $favoriteInfo = FJF_BASE_RICH::getRecord("users_sellers_favorites", "seller_id = 'SELLER_ID' AND user_id = 'USER_ID'", array("SELLER_ID" => $sellerID, "USER_ID" => $userID));
                if ($favoriteInfo == null) {
                    $fields["user_id"] = $userID;
                    $fields["seller_id"] = $sellerID;
                    $fields["date"] = date("Y-m-d H:i:s");
                    $insertResult = FJF_BASE_RICH::insertRecord("users_sellers_favorites", $fields, "id");
                    if ($insertResult) {
                        $data["status"] = "Success";
                    }
                }
            }
            exit(json_encode($data));
        }
    }
}

?>
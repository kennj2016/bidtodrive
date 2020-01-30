<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class SwitchAccount extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $type = isset($_REQUEST["type"]) ? trim($_REQUEST["type"]) : "Buyer";
        $userID = SessionModel::loggedUserID();

        $fields["id"] = $userID;
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);

        if ($user->user_type_origin == 'Seller') {
            $fields["user_type"] = $type;
            FJF_BASE_RICH::updateRecord("users", $fields, "id");
        } elseif($user->user_type_origin == 'Buyer' && $type == 'Seller') {
            FJF_BASE::redirect('/account/switch-to-seller-form');
        }

        $this->sessionModel->logout();
        session_destroy();
        $data = array(
            "email" => $user->email,
            "remember" => 1
        );
        $this->sessionModel->login($user, $data["remember"]);
        if(trim($_REQUEST["type"]) == 'Buyer'){
            FJF_BASE::redirect('/auctions/');
        }else{
            FJF_BASE::redirect('/account/listings/');

        }
    }
}

?>

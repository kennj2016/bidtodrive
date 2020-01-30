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
        $userID = SessionModel::loggedUserID();

        $fields["id"] = $userID;
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);

        if ($user->user_type_origin == 'Seller' && $user->user_type == 'Seller') {
            $fields["user_type"] = 'Buyer';
            FJF_BASE_RICH::updateRecord("users", $fields, "id");
        }

        $this->sessionModel->logout();
        $data = array(
            "email" => $user->email,
            "remember" => 1
        );
        $this->sessionModel->login($user, $data["remember"]);
        FJF_BASE::redirect('/');
    }
}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class ResetPassword extends FJF_CMD
{

    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        SessionModel::redirectUser();
    }

    function execute()
    {

        $this->pageModel->loadSettings("login");

        $errors = "";
        $status = "";

        $action = isset($_GET["action"]) ? trim($_GET["action"]) : "";

        if ($action == 'reset') {
            $user = null;
            $resetID = isset($_GET["reset_id"]) ? trim($_GET["reset_id"]) : null;
            if ($resetID) {
                $refreshID = substr($resetID, 0, 8);
                $userID = intval(FJF_BASE::decrypt(substr($resetID, 8), "refresh-password"));
                $user = $userID && $refreshID ? FJF_BASE_RICH::getRecord(
                    "users",
                    "id='ID_VAL' AND password_refresh ='REFRESH_VAL'",
                    array(
                        "REFRESH_VAL" => $refreshID,
                        "ID_VAL" => $userID
                    )
                ) : null;
            }

            if (!$user) {
                $errors[] = "Invalid reset password code.";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
                $confirm = isset($_POST["confirm_password"]) ? trim($_POST["confirm_password"]) : "";

                if (!$password && !$confirm) {
                    $errors[] = "Password is missing.<br />";
                } elseif ($password && strlen($password) < 6) {
                    $errors[] = "Password must contain at least 6 characters.<br />";
                } elseif ($password != $confirm) {
                    $errors[] = "Your passwords don't match.<br />";
                }

                if (!$errors) {
                    if (SessionModel::updatePassword($user->id, $password)) {
                        $status = "Your password has been reset successfully.";
                    } else {
                        $errors[] = "An error occurred while saving record to DB.";
                    }
                }

                return $this->displayJSON(array("errors" => $errors, "status" => $status));
            }
        }

        return $this->displayTemplate("reset_password.tpl", array(
            "action" => $action
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");

class AccountSecurityAccess extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $hasError = false;
        $status = "";

        $userID = SessionModel::loggedUserID();
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);
        if ($user->profile_photo) {
            $user->profile_photo_info = SiteMediaModel::getFile($user->profile_photo);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $oldPassword = (isset($_REQUEST["old_password"])) ? trim($_REQUEST["old_password"]) : "";
            $newPassword = (isset($_REQUEST["new_password"])) ? trim($_REQUEST["new_password"]) : "";
            $confirmPassword = (isset($_REQUEST["confirm_password"])) ? trim($_REQUEST["confirm_password"]) : "";

            if ($oldPassword == "") {
                $hasError = true;
                $status .= "Current Password is missing.<br/>";
            }

            if ($newPassword == "") {
                $hasError = true;
                $status .= "New Password is missing.<br/>";
            }

            if ($confirmPassword == "") {
                $hasError = true;
                $status .= "Confirm Password is missing.<br/>";
            }

            if (!$hasError) {
                if (md5($oldPassword) == $user->password) {
                    if ($newPassword == $confirmPassword) {
                        if (strlen($newPassword) < 8) {
                            $hasError = true;
                            $status .= "Password must contain at least 8 characters.<br/>";
                        } elseif (!preg_match('/[^a-zA-Z]+/', $newPassword)) {
                            $hasError = true;
                            $status .= "Password must include at least one number or special character.<br/>";
                        } elseif (!preg_match('/[a-zA-Z]/', $newPassword)) {
                            $hasError = true;
                            $status .= "Password must include at least one letter.<br/>";
                        }
                    } else {
                        $hasError = true;
                        $status .= "Your passwords don't match.<br/>";
                    }
                } else {
                    $hasError = true;
                    $status = "'Current Password' don't match your password.<br/>";
                }
            }

            if (!$hasError) {
                $data["id"] = $userID;
                $data["password"] = md5($newPassword);
                if (!FJF_BASE_RICH::saveRecord("users", $data)) {
                    $hasError = true;
                    $status = "An error occurred while saving info.";
                } else {
                    $status = "Your password has been reset successfully.";
                }
            }
        }

        $this->pageModel->setMetadata("title", "Security & Access");

        return $this->displayTemplate("account_security_access.tpl", array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
        ));
    }

}

?>
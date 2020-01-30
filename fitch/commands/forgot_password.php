<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class ForgotPassword extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new    SessionModel();
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        $this->pageModel->loadSettings("login");
        $page = $this->pageModel->getSettings();

        $errors = "";
        $status = "";

        if (SessionModel::isUser()) {
            $errors[] = "You are logged in.";
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = isset($_POST["forgot_email"]) ? trim($_POST["forgot_email"]) : "";

                if (!$email) {
                    $errors = "Email is	missing.";
                } elseif (!preg_match("/^.+\@.+\..+$/", $email)) {
                    $errors = "Invalid Email format.";
                }

                if (!$errors) {
                    $user = FJF_BASE_RICH::getRecord("users", "email='EMAIL'", array("EMAIL" => $email));

                    if (is_object($user)) {
                        $data["id"] = $user->id;
                        $rp = SessionModel::getRandString(8);
                        $result = FJF_BASE_RICH::saveRecord("users", array("id" => $user->id, "password_refresh" => $rp));
                        if ($result) {
                            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
                            $link = "http://" . $_SERVER["SERVER_NAME"] . "/reset-password/" . $rp . urlencode(urlencode(FJF_BASE::encrypt($user->id, "refresh-password"))) . "/";
                            $message = "Please click here to reset your password:<br/>";
                            $message .= "<br/>";
                            $message .= "<a href='" . $link . "'>" . $link . "</a>";

                            MailModel::sendEmail(
                                $user->email,
                                "Forgot Password",
                                $message,
                                $user->email,
                                $user->name
                            );
                        } else {
                            $errors = "Error occurred while processing your data.<br/>Please, contact support.";
                        }
                    } else {
                        $errors = "Your Email Address is not recognized.";
                    }
                }

                if (!$errors) {
                    $status = "A link to update your password has been sent to your email.";
                }

                return $this->displayJSON(array("errors" => $errors, "status" => $status));
            }
        }

        return $this->displayTemplate("forgot_password.tpl", array("page" => $page));
    }

}

?>
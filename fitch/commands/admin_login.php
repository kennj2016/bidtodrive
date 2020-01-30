<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminLogin extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->sessionModel->redirectAdmin(isset($_GET['redirect']) ? $_GET['redirect'] : null);
        $this->sessionModel->redirectUser("/");
    }

    function execute()
    {
        $hasError = true;
        $status = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
            $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
            $remember = isset($_POST["remember"]) && $_POST["remember"];

            if (!$email || !$password) {
                $hasError = true;
                $status = "Please enter your email and password.";
            } elseif (!$user = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL' AND password='PASSWORD_VAL'", array(
                'EMAIL_VAL' => $email,
                'PASSWORD_VAL' => md5($password)
            ))) {
                $hasError = true;
                $status = "Invalid login information.";
            } elseif (!$user->status) {
                $hasError = true;
                $status = "Your account is disabled.";
            } else {
                $this->sessionModel->login($user, $remember);
                $this->sessionModel->redirectAdmin(isset($_GET['redirect']) ? $_GET['redirect'] : null);
                $this->sessionModel->redirectUser("/");
            }

        }//POST

        $header["title"] = "Login";

        return $this->displayTemplate("admin_login.tpl", array(
            "header" => $header,
            "has_error" => $hasError,
            "status" => $status
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class Login extends FJF_CMD
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
        $page = $this->pageModel->getSettings();

        $homepageInfo = FJF_BASE_RICH::getRecord("site_data", "name = 'homepage'");
        $homepageInfoData = json_decode($homepageInfo->data);
        $page->left_title = is_object($homepageInfoData) && $homepageInfoData != "" ? $homepageInfoData->hero_title : "";
        $page->left_description = is_object($homepageInfoData) && $homepageInfoData != "" ? $homepageInfoData->hero_subtitle : "";

        $response = array(
            "status" => false,
            "message" => "",
            "redirect" => "/"
        );

        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            RecordsModel::autoUpdateStatusAuction();
            $data = array(
                "email" => isset($_POST["username"]) ? trim($_POST["username"]) : "",
                "password" => isset($_POST["password"]) ? trim($_POST["password"]) : "",
                "remember" => isset($_POST["remember"]) ? intval($_POST["remember"]) : 0
            );
            $response["redirect"] = isset($_REQUEST["redirect"]) ? trim($_REQUEST["redirect"]) : "/auctions/";
            $errors = array();
            if (SessionModel::isUser()) {
                $errors[] = "You are logged in.";
            } else {
                if (!$data["email"]) {
                    $errors[] = "Email is missing.";
                } elseif (!preg_match("/^.+\@.+\..+$/", $data["email"])) {
                    $errors[] = "Invalid Email format.";
                }

                if (!$data["password"]) {
                    $errors[] = "Password is missing.";
                }

                if (!$errors) {
                    if (!$user = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL' AND password='PASSWORD_VAL'", array(
                        'EMAIL_VAL' => $data["email"],
                        'PASSWORD_VAL' => md5($data["password"])
                    ))) {
                        $errors[] = "Your login information is wrong.";
                    } elseif ($user->status == 0) {
                        $errors[] = "Your account is disabled.";
                    } else {
                        $this->sessionModel->login($user, $data["remember"]);
                    }
                }
            }

            if ($errors) {
                $response["message"] = implode("<br />", $errors);
            }
            return $this->displayJSON($response);
        }

        return $this->displayTemplate("login.tpl", array(
            "page" => $page
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class Contact extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        $this->pageModel->loadSettings("contact");
        $settings = $this->pageModel->getSettings();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->isAjax()) {
            $response = array("status" => false, "message" => "");

            $data = array(
                "name" => isset($_POST["name"]) ? trim($_POST["name"]) : "",
                "email" => isset($_POST["email"]) ? trim($_POST["email"]) : "",
                "contact_reason" => isset($_POST["contact_reason"]) ? trim($_POST["contact_reason"]) : "",
                "message" => isset($_POST["message"]) ? trim($_POST["message"]) : "",
                "form" => "Contact Us"
            );

            $errors = array();

            if (!$data["name"]) {
                $errors[] = "Name is missing.";
            }

            if (!$data["email"]) {
                $errors[] = "Email is missing.";
            } elseif (!preg_match("/^.+\@.+\..{2,}$/", $data["email"])) {
                $errors[] = "Invalid Email format.";
            }

            if (!$data["message"]) {
                $errors[] = "Message is missing.";
            }

            if ($errors) {
                $response["message"] = implode("\n ", $errors);
            } else {
                if (FJF_BASE_RICH::saveRecord("form_contact", $data)) {

                    $response["status"] = true;
                    include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

                    if ($settings->form_submissions) {
                        $message = "";
                        $message .= "<b>NAME:</b> " . $data["name"] . "<br />";
                        $message .= "<b>EMAIL:</b> " . $data["email"] . "<br />";
                        $message .= "<b>CONTACT REASON:</b> " . $data["contact_reason"] . "<br />";
                        $message .= "<br />";
                        $message .= "<b>MESSAGE:</b><br />" . $data["message"] . "<br />";

                        MailModel::sendEmail(
                            $settings->form_submissions,
                            "Contact Us Form",
                            $message,
                            $data["email"],
                            $data["name"]
                        );
                    }
                } else {
                    $response["message"] = "Failed to save record to DB.";
                }
            }
            exit(json_encode($response));
        }

        return $this->displayTemplate("contact.tpl", array(
            "settings" => $settings
        ));
    }

}

?>
<?php

class AjaxContact extends FJF_CMD
{

    function execute()
    {

        $response = array(
            "status" => false,
            "message" => ""
        );

        $data = array(
            "name" => isset($_POST["name"]) ? trim($_POST["name"]) : "",
            "email" => isset($_POST["email"]) ? trim($_POST["email"]) : "",
            "contact_reason" => isset($_POST["contact_reason"]) ? trim($_POST["contact_reason"]) : "",
            "message" => isset($_POST["message"]) ? trim($_POST["message"]) : ""
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
            $response["message"] = implode("\n", $errors);
        } else {

            if (FJF_BASE_RICH::saveRecord("form_contact", $data)) {

                $response["status"] = true;

                $emails = array();
                if ($sv = FJF_BASE_RICH::getRecord("site_vars", "name='footer_contact_email_notifications' AND value<>''")) {
                    $emails = array_filter(array_map("trim", explode(",", $sv->value)), "strlen");
                }

                include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

                if ($emails) {
                    $message = "";
                    $message .= "<b>NAME:</b> " . $data["name"] . "<br />";
                    $message .= "<b>EMAIL:</b> " . $data["email"] . "<br />";
                    $message .= "<b>CONTACT REASON:</b> " . $data["contact_reason"] . "<br />";
                    $message .= "<br />";
                    $message .= "<b>MESSAGE:</b><br />" . $data["message"] . "<br />";

                    MailModel::sendEmail(
                        $emails,
                        "Footer Contact Form",
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


}

?>
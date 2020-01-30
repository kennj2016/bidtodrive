<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

class SwitchAccountSeller extends FJF_CMD
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
        $userID = SessionModel::loggedUserID();
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);
        $message = "";
        if ($_POST) {
//            print_r($_POST);exit;
            $fields["id"] = $userID;
            $fields["dealers_license_issued_to"] = $_REQUEST["dealers_license_issued_to"];
            $fields["dealers_license_number"] = $_REQUEST["dealers_license_number"];
            $fields["dealers_license_state"] = $_REQUEST["dealers_license_state"];
            $fields["dealers_license_issue_date"] = date('Y-m-d H:i:s', strtotime($_REQUEST["dealers_license_issue_date"]));
            $fields["dealers_license_expiration_date"] = date('Y-m-d H:i:s', strtotime($_REQUEST["dealers_license_expiration_date"]));
            $fields["upgrade_seller_note"] = $_REQUEST["upgrade_seller_note"];
            $fields["status_upgrade"] = 1;
//            $fields["dealers_license_photo"] = $_REQUEST["dealers_license_photo"];

//            $fields["upgrade_seller_note"] = $_POST['note'];
            FJF_BASE_RICH::updateRecord("users", $fields, "id");
            $this->sendMail($user, $_REQUEST);
            $message = "Request to switch account to seller successfully";
        }

        $this->pageModel->setMetadata("title", "Request to be Seller");
        return $this->displayTemplate("switch_account_seller.tpl", array(
            "user" => isset($user) ? $user : null, "message" => $message
        ));
    }

    public function sendMail($user, $request) {
        try {
            $message = "";
            $message .= "<b>User name:</b> " . $user->name . "<br />";
            $message .= "<b>Email:</b> " . $user->email . "<br />";
            $message .= "<b>Dealers license issued to:</b> " . $request["dealers_license_issued_to"] . "<br />";
            $message .= "<b>Dealers license number:</b> " . $request["dealers_license_number"] . "<br />";
            $message .= "<b>Dealers license state:</b> " . $request["dealers_license_state"] . "<br />";
            $message .= "<b>Dealers license issue date:</b> " . $request["dealers_license_issue_date"] . "<br />";
            $message .= "<b>Dealers license expiration date:</b> " . $request["dealers_license_expiration_date"] . "<br />";
            $message .= "<b>Message:</b> " . $request["upgrade_seller_note"] . "<br />";

            $message .= "<br />";

            $this->pageModel->loadSettings("contact");
            $settings = $this->pageModel->getSettings();
            $mail = new MailModel();
            $mail->sendEmail(
//                'janna94nd@gmail.com',
                $settings->form_submissions,
                "Request to be Seller",
                $message,
                $user->email,
                $user->name
            );
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

?>

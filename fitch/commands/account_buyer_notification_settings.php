<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");

class AccountBuyerNotificationSettings extends FJF_CMD
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
            $fields["id"] = $userID;
            $fields["notification_type_2"] = (isset($_POST["notification_type_2"])) ? intval($_POST["notification_type_2"]) : 0;

            // Buyer: Notify when my listing is expiring should cover: A. TYPE_BUYER-LISTING_EXPIRING_24HOURS, B. TYPE_BUYER_LISTING_EXPIRING_1HOUR, C. TYPE_BUYER_LISTING_EXPIRING_5MINUTES
            $fields["notification_type_4"] = (isset($_POST["notification_type_4"])) ? intval($_POST["notification_type_4"]) : 0;
            $fields["notification_type_5"] = $fields["notification_type_4"];
            $fields["notification_type_6"] = $fields["notification_type_4"];
            $fields["notification_type_7"] = (isset($_POST["notification_type_7"])) ? intval($_POST["notification_type_7"]) : 0;
            $fields["notification_type_8"] = (isset($_POST["notification_type_8"])) ? intval($_POST["notification_type_8"]) : 0;

            // "Notify me when I win an auction" should trigger both the TYPE_BUYER_WINS_AUCTION and TYPE_BUYER_BUY_NOW
            $fields["notification_type_20"] = $fields["notification_type_2"];

            // Notify me when I make a bid
            $fields["notification_type_18"] = (isset($_POST["notification_type_18"])) ? intval($_POST["notification_type_18"]) : 0;
            $fields["notification_type_23"] = (isset($_POST["notification_type_23"])) ? intval($_POST["notification_type_23"]) : 1;

            $fields["notification_channel"] = (isset($_POST["notification_channel"])) ? trim($_POST["notification_channel"]) : "both";

            if (!$hasError && FJF_BASE_RICH::updateRecord("users", $fields, "id")) {
                $response["status"] = "Your notification settings was updated successfully.";
            } else {
                $hasError = true;
                $status = "An error occurred while saving info.";
            }
        }

        $this->pageModel->setMetadata("title", "Notification Settings");

        return $this->displayTemplate("account_buyer_notification_settings.tpl", array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");

class AccountSellerNotificationSettings extends FJF_CMD
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
            //Notify me when my listing is about to expire A. TYPE_SELLER_LISTING_EXPIRING_24HOURS, B. TYPE_SELLER_LISTING_EXPIRING_1HOUR C. TYPE_SELLER_LISTING_EXPIRING_5MINUTES
            $fields["notification_type_9"] = (isset($_REQUEST["notification_type_9"])) ? intval($_REQUEST["notification_type_9"]) : 0;
            $fields["notification_type_10"] = $fields["notification_type_9"];
            $fields["notification_type_11"] = $fields["notification_type_9"];

            //Notify me if my reserve price is not met at an auction's conclusion TYPE_SELLER_LISTING_ENDED_WITHOUT_MEETING_RESERVE
            $fields["notification_type_13"] = (isset($_REQUEST["notification_type_13"])) ? intval($_REQUEST["notification_type_13"]) : 0;

            //Notify me when buyers make a bid on my auctions TYPE_SELLER_BID_PLACED
            $fields["notification_type_12"] = (isset($_REQUEST["notification_type_12"])) ? intval($_REQUEST["notification_type_12"]) : 0;

            //Notify me when an auction is successfully completed A. TYPE_SELLER_AUCTION_COMPLETES_SUCCESSFULLY B. TYPE_SELLER_BUY_NOW
            $fields["notification_type_3"] = (isset($_REQUEST["notification_type_3"])) ? intval($_REQUEST["notification_type_3"]) : 0;
            $fields["notification_type_19"] = $fields["notification_type_3"];

            $fields["notification_channel"] = (isset($_POST["notification_channel"])) ? trim($_POST["notification_channel"]) : "both";

            if (!$hasError && FJF_BASE_RICH::updateRecord("users", $fields, "id")) {
                $hasError = false;
                $status = "Your notification settings was updated successfully.";
            } else {
                $hasError = true;
                $status = "An error occurred while saving info.";
            }
        }

        $this->pageModel->setMetadata("title", "Notification Settings");

        return $this->displayTemplate("account_seller_notification_settings.tpl", array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
        ));
    }

}

?>
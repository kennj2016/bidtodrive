<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class CronExpiringLicenses extends FJF_CMD
{
    var $sessionModel = null;
    var $notificationModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->notificationModel = new NotificationModel();
    }

    function execute()
    {
        $timeNow = time();
        $buyers = FJF_BASE_RICH::getRecords("users", "status = 1 AND license_expired = 0 AND user_type = 'Buyer'", [], false);
        if (!empty($buyers)) {
            foreach ($buyers as $buyer) {
                $timeDriverLicenseExpirationDate = (isset($buyer->license_expiration_date) && $buyer->license_expiration_date != "") ? strtotime($buyer->license_expiration_date) : 0;
                $timeDealerLicenseExpirationDate = (isset($buyer->dealers_license_expiration_date) && $buyer->dealers_license_expiration_date != "") ? strtotime($buyer->dealers_license_expiration_date) : 0;
                if ($buyer->buyer_type == "Individual") {
                    // YOUR DRIVERS'S LICENSE EXPIRES SOON ON [DATE] 15
                    if ($timeDriverLicenseExpirationDate > $timeNow && $timeNow > ($timeDriverLicenseExpirationDate - 259200)) {
                        $notificationData["type"] = NotificationModel::TYPE_DRIVER_LICENSE_EXPIRES;
                        $notificationData["uid"] = $buyer->uid;
                        $notificationData["notification"] = json_encode(["user_id" => $buyer->id, "name" => $buyer->name, "email" => $buyer->email, "license_type" => "Driver", "license_expiration_date" => date("F j, Y", $timeDriverLicenseExpirationDate)]);
                        $this->notificationModel->insertNotification($notificationData, $buyer);
                    }

                    // YOUR DRIVER'S LICENSE HAS EXPIRED
                    if ($timeDriverLicenseExpirationDate < $timeNow) {
                        $notificationData["type"] = NotificationModel::TYPE_DRIVER_LICENSE_EXPIRED;
                        $notificationData["uid"] = $buyer->uid;
                        $notificationData["notification"] = json_encode(["user_id" => $buyer->id, "name" => $buyer->name, "email" => $buyer->email, "license_type" => "Driver", "license_expiration_date" => date("F j, Y", $timeDriverLicenseExpirationDate)]);
                        $this->notificationModel->insertNotification($notificationData, $buyer);
                        FJF_BASE_RICH::updateRecord("users", ["id" => $buyer->id, "license_expired" => 1], "id");
                    }
                } elseif ($buyer->buyer_type == "Dealer") {
                    // YOUR DEALERS'S LICENSE EXPIRES SOON ON [DATE] 14
                    if ($timeDealerLicenseExpirationDate > $timeNow && $timeNow > ($timeDealerLicenseExpirationDate - 259200)) {
                        $notificationData["type"] = NotificationModel::TYPE_DEALER_LICENSE_EXPIRES;
                        $notificationData["uid"] = $buyer->uid;
                        $notificationData["notification"] = json_encode(["user_id" => $buyer->id, "name" => $buyer->name, "email" => $buyer->email, "license_type" => "Dealer", "license_expiration_date" => date("F j, Y", $timeDealerLicenseExpirationDate)]);
                        $this->notificationModel->insertNotification($notificationData, $buyer);
                    }

                    // YOUR DEALER'S LICENSE HAS EXPIRED
                    if ($timeDealerLicenseExpirationDate < $timeNow) {
                        $notificationData["type"] = NotificationModel::TYPE_DEALER_LICENSE_EXPIRED;
                        $notificationData["uid"] = $buyer->uid;
                        $notificationData["notification"] = json_encode(["user_id" => $buyer->id, "name" => $buyer->name, "email" => $buyer->email, "license_type" => "Dealer", "license_expiration_date" => date("F j, Y", $timeDealerLicenseExpirationDate)]);
                        $this->notificationModel->insertNotification($notificationData, $buyer);
                        FJF_BASE_RICH::updateRecord("users", ["id" => $buyer->id, "license_expired" => 1], "id");
                    }
                }
            }
        }

        $sellers = FJF_BASE_RICH::getRecords("users", "status = 1 AND license_expired = 0 AND user_type = 'Seller'", [], false);
        if (!empty($sellers)) {
            foreach ($sellers as $seller) {
                $timeDealerLicenseExpirationDate = (isset($seller->dealers_license_expiration_date) && $seller->dealers_license_expiration_date != "") ? strtotime($seller->dealers_license_expiration_date) : 0;
                // YOUR DEALERS'S LICENSE EXPIRES SOON ON [DATE] 14
                if ($timeDealerLicenseExpirationDate > 0 && $timeNow > ($timeDealerLicenseExpirationDate - 259200)) {
                    $notificationData["type"] = NotificationModel::TYPE_DEALER_LICENSE_EXPIRES;
                    $notificationData["uid"] = $seller->uid;
                    $notificationData["notification"] = json_encode(["user_id" => $seller->id, "name" => $seller->name, "email" => $seller->email, "license_type" => "Dealer", "license_expiration_date" => date("F j, Y", $timeDealerLicenseExpirationDate)]);
                    $this->notificationModel->insertNotification($notificationData, $seller , 1);
                }

                // YOUR DEALER'S LICENSE HAS EXPIRED
                if ($timeDealerLicenseExpirationDate < $timeNow) {
                    $notificationData["type"] = NotificationModel::TYPE_DEALER_LICENSE_EXPIRED;
                    $notificationData["uid"] = $seller->uid;
                    $notificationData["notification"] = json_encode(["user_id" => $seller->id, "name" => $seller->name, "email" => $seller->email, "license_type" => "Dealer", "license_expiration_date" => date("F j, Y", $timeDealerLicenseExpirationDate)]);
                    $this->notificationModel->insertNotification($notificationData, $seller , 1);
                    FJF_BASE_RICH::updateRecord("users", ["id" => $seller->id, "license_expired" => 1], "id");
                }
            }
        }
        exit("Done.");
    }
}

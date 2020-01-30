<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class CronExpiringCards extends FJF_CMD
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
        $date = new DateTime();
        $currentYear = $date->format("Y");
        $currentMonth = $date->format("n");
        $currentDay = $date->format("j");
        $numberOfDaysInMonth = $date->format("t");
        if ($currentDay == 1 || $currentDay == ($numberOfDaysInMonth - 5)) {
            $buyers = FJF_BASE_RICH::getRecords("users", "status = 1 AND user_type = 'Buyer' AND stripe_id <> '' AND cc_expired = 0 AND cc_exp_month = 'CC_EXP_MONTH' AND cc_exp_year = 'CC_EXP_YEAR'", ["CC_EXP_MONTH" => $currentMonth, "CC_EXP_YEAR" => $currentYear], false);
            if (!empty($buyers)) {
                foreach ($buyers as $buyer) {
                    // BUYER - EXPIRES CREDIT CARD
                    $dbExpDate = new DateTime($currentYear . "-" . $currentMonth . "-" . $numberOfDaysInMonth);
                    $notificationData["type"] = NotificationModel::TYPE_BUYER_CC_EXPIRES;
                    $notificationData["uid"] = $buyer->uid;
                    $notificationData["notification"] = json_encode([
                        "cc_exp_date" => $dbExpDate->format("F j, Y"),
                        "cc_exp_number" => $buyer->cc_exp_number
                    ]);
                    $this->notificationModel->insertNotification($notificationData, $buyer);
                }
            }
        }
        exit("Done.");
    }
}
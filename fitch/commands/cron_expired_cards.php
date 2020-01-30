<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class CronExpiredCards extends FJF_CMD
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
        if ($currentDay == $numberOfDaysInMonth) {
            $buyers = FJF_BASE_RICH::getRecords("users", "status = 1 AND user_type = 'Buyer' AND stripe_id <> '' AND cc_expired = 0 AND cc_exp_month = 'CC_EXP_MONTH' AND cc_exp_year = 'CC_EXP_YEAR'", ["CC_EXP_MONTH" => $currentMonth, "CC_EXP_YEAR" => $currentYear], false);
            if (!empty($buyers)) {
                foreach ($buyers as $buyer) {
                    $sendExpiredNotification = false;
                    StripeModel::setApiKey();
                    $stripeCustomerInfo = StripeModel::getCustomerCard($buyer->stripe_id);
                    $dbExpDate = new DateTime($currentYear . "-" . $currentMonth . "-" . $numberOfDaysInMonth);
                    if (is_object($stripeCustomerInfo)) {
                        $stripeExpYearMonth = new DateTime($stripeCustomerInfo->exp_year . "-" . $stripeCustomerInfo->exp_month);
                        $stripeExpDate = new DateTime($stripeCustomerInfo->exp_year . "-" . $stripeCustomerInfo->exp_month . "-" . $stripeExpYearMonth->format("t"));
                        if ($stripeExpDate > $dbExpDate) {
                            FJF_BASE_RICH::updateRecord("users", [
                                "id" => $buyer->id,
                                "cc_exp_month" => $stripeCustomerInfo->exp_month,
                                "cc_exp_year" => $stripeCustomerInfo->exp_year,
                                "cc_expired" => 0
                            ], "id");
                        } else {
                            $sendExpiredNotification = true;
                            FJF_BASE_RICH::updateRecord("users", ["id" => $buyer->id, "cc_expired" => 1], "id");
                        }
                    } else {
                        $sendExpiredNotification = true;
                        FJF_BASE_RICH::updateRecord("users", ["id" => $buyer->id, "cc_expired" => 1], "id");
                    }

                    if ($sendExpiredNotification) {
                        // BUYER - EXPIRED CREDIT CARD
                        $notificationData["type"] = NotificationModel::TYPE_BUYER_CC_EXPIRED;
                        $notificationData["uid"] = $buyer->uid;
                        $notificationData["notification"] = json_encode([
                            "cc_exp_date" => $dbExpDate->format("F j, Y"),
                            "cc_exp_number" => $buyer->cc_exp_number
                        ]);
                        $this->notificationModel->insertNotification($notificationData, $buyer);
                    }
                }
            }
        }
        exit("Done.");
    }
}
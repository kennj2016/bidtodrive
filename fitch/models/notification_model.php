<?php

require $GLOBALS["WEB_APPLICATION_CONFIG"]["resources_path"] . "/vendor/autoload.php";
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

use Twilio\Rest\Client as TwilioClient;

class NotificationModel
{
    const TYPE_BUYER_REGISTRATION_CONFIRMATION = 1;
    const TYPE_BUYER_WINS_AUCTION = 2;
    const TYPE_SELLER_AUCTION_COMPLETES_SUCCESSFULLY = 3;
    const TYPE_BUYER_LISTING_EXPIRING_24HOURS = 4;
    const TYPE_BUYER_LISTING_EXPIRING_1HOUR = 5;
    const TYPE_BUYER_LISTING_EXPIRING_5MINUTES = 6;
    const TYPE_BUYER_OUTBID_AUCTION = 7;
    const TYPE_BUYER_NEW_AUCTION_FROM_WATCHED_SELLER = 8;
    const TYPE_SELLER_LISTING_EXPIRING_24HOURS = 9;
    const TYPE_SELLER_LISTING_EXPIRING_1HOUR = 10;
    const TYPE_SELLER_LISTING_EXPIRING_5MINUTES = 11;
    const TYPE_SELLER_BID_PLACED = 12;
    const TYPE_SELLER_LISTING_ENDED_WITHOUT_MEETING_RESERVE = 13;
    const TYPE_DEALER_LICENSE_EXPIRES = 14;
    const TYPE_DRIVER_LICENSE_EXPIRES = 15;
    const TYPE_DRIVER_LICENSE_EXPIRED = 16;
    const TYPE_DEALER_LICENSE_EXPIRED = 17;
    const TYPE_BUYER_BID_PLACED = 18;
    const TYPE_SELLER_BUY_NOW = 19;
    const TYPE_BUYER_BUY_NOW = 20;
    const TYPE_SELLER_PAYMENT_FAILURE = 21;
    const TYPE_BUYER_PAYMENT_FAILURE = 22;
    const TYPE_BUYER_CC_EXPIRES = 23;
    const TYPE_BUYER_CC_EXPIRED = 24;

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return array(
            self::TYPE_BUYER_REGISTRATION_CONFIRMATION => "BUYER_REGISTRATION_CONFIRMATION",
            self::TYPE_BUYER_WINS_AUCTION => "BUYER_WINS_AUCTION",
            self::TYPE_SELLER_AUCTION_COMPLETES_SUCCESSFULLY => "SELLER_AUCTION_COMPLETES_SUCCESSFULLY",
            self::TYPE_BUYER_LISTING_EXPIRING_24HOURS => "BUYER_LISTING_EXPIRING_24HOURS",
            self::TYPE_BUYER_LISTING_EXPIRING_1HOUR => "BUYER_LISTING_EXPIRING_1HOUR",
            self::TYPE_BUYER_LISTING_EXPIRING_5MINUTES => "BUYER_LISTING_EXPIRING_5MINUTES",
            self::TYPE_BUYER_OUTBID_AUCTION => "BUYER_OUTBID_AUCTION",
            self::TYPE_BUYER_NEW_AUCTION_FROM_WATCHED_SELLER => "BUYER_NEW_AUCTION_FROM_WATCHED_SELLER",
            self::TYPE_SELLER_LISTING_EXPIRING_24HOURS => "SELLER_LISTING_EXPIRING_24HOURS",
            self::TYPE_SELLER_LISTING_EXPIRING_1HOUR => "SELLER_LISTING_EXPIRING_1HOUR",
            self::TYPE_SELLER_LISTING_EXPIRING_5MINUTES => "SELLER_LISTING_EXPIRING_5MINUTES",
            self::TYPE_SELLER_BID_PLACED => "SELLER_BID_PLACED",
            self::TYPE_SELLER_LISTING_ENDED_WITHOUT_MEETING_RESERVE => "SELLER_LISTING_ENDED_WITHOUT_MEETING_RESERVE",
            self::TYPE_DEALER_LICENSE_EXPIRES => "DEALER_LICENSE_EXPIRES",
            self::TYPE_DRIVER_LICENSE_EXPIRES => "DRIVER_LICENSE_EXPIRES",
            self::TYPE_DRIVER_LICENSE_EXPIRED => "DRIVER_LICENSE_EXPIRED",
            self::TYPE_DEALER_LICENSE_EXPIRED => "DEALER_LICENSE_EXPIRED",
            self::TYPE_BUYER_BID_PLACED => "BUYER_BID_PLACED",
            self::TYPE_SELLER_BUY_NOW => "SELLER_BUY_NOW",
            self::TYPE_BUYER_BUY_NOW => "BUYER_BUY_NOW",
            self::TYPE_SELLER_PAYMENT_FAILURE => "SELLER_PAYMENT_FAILURE",
            self::TYPE_BUYER_PAYMENT_FAILURE => "BUYER_PAYMENT_FAILURE",
            self::TYPE_BUYER_CC_EXPIRES => "BUYER_CC_EXPIRES",
            self::TYPE_BUYER_CC_EXPIRED => "BUYER_CC_EXPIRED",
        );
    }

    /**
     * @param array $data
     * @param null $recipient
     * @return bool
     */
    public function insertNotification($data = [], $recipient = null , $type = null)
    {
        FJF_BASE_RICH::insertRecord("notifications", $data);

        if (!empty($recipient)) {
            $userPhone = (isset($recipient->mobile_number) && $recipient->mobile_number != "") ? preg_replace("~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~", "+1$1$2$3", $recipient->mobile_number) : "";
            $typeProperty = "notification_type_" . $data["type"];
            $sendNotification = (isset($recipient->{$typeProperty})) ? intval($recipient->{$typeProperty}) : 0;
            if ($sendNotification == 1) {
                $notificationChannel = ($recipient->notification_channel != "") ? $recipient->notification_channel : "";
                $notificationText = $this->getNotificationText($data["type"], json_decode($data["notification"], true) , $type);
                if ($userPhone != "" && $notificationText != "" && ($notificationChannel == "both" || $notificationChannel == "sms")) {
                    $client = new TwilioClient("ACbb2a4ef25c804f4d62d2fb30875080ea", "e703e171fd6e95f59ce8649dfda7dd55");
                    try {
                        $client->messages->create($userPhone, array("from" => "+19083328900", "body" => $notificationText));
                    } catch (Exception $e) {

                    }
                }
                if ($notificationChannel == "both" || $notificationChannel == "email") {
                    MailModel::sendNotificationEmail($recipient, $data);
                }
            }

        }

        return true;
    }

    /**
     * @param int $notificationType
     * @param array $notification
     * @return string
     */
    public function getNotificationText($notificationType = 0, $notification = [] , $type = null)
    {
        $siteUrl = "https://" . $_SERVER["SERVER_NAME"];
        if ($type == null){
          switch ($notificationType) {
              case 1:
                  $notificationText = "Buyer registration confirmation";
                  break;
              case 2:
                  $notificationText = "You won " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " with a bid of $" . FJF_BASE::moneyFormat($notification["final_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 3:
                  $notificationText = "Your auction for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . "is complete with a winning bid of $" . FJF_BASE::moneyFormat($notification["final_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 4:
                  $notificationText = "Your watched listing ends in 24 hours: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 5:
                  $notificationText = "Your watched listing ends in 1 hour: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 6:
                  $notificationText = "Your watched listing ends in 5 minutes: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 7:
                  $notificationText = "You were outbid on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". The new high bid is $" . FJF_BASE::moneyFormat($notification["amount"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 8:
                  $notificationText = "New auction from " . $notification["seller_name"] . ": " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"];
                  break;
              case 9:
                  $notificationText = "Your listing ends in 24 hours: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 10:
                  $notificationText = "Your listing ends in 1 hour: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 11:
                  $notificationText = "Your listing ends in 5 minutes: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 12:
                  $notificationText = "New bid on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " by " . $notification["buyer_name"] . " for $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 13:
                  $notificationText = "Your auction for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " ended without meeting the reserve price. View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/. Relist auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/relist/. Accept High Bid: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/accept-highest-bid/";
                  break;
              case 14:
                  $notificationText = "Your dealer license expires soon on " . $notification["license_expiration_date"] . ". Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/";
                  break;
              case 15:
                  $notificationText = "Your driver's license expires soon on " . $notification["license_expiration_date"] . ". Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/buyer/";
                  break;
              case 16:
                  $notificationText = "Your driver's license has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/buyer/";
                  break;
              case 17:
                  $notificationText = "Your dealer license has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/";
                  break;
              case 18:
                  $notificationText = "You bid $" . FJF_BASE::moneyFormat($notification["amount"]) . " on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 19:
                  $notificationText = "Your auction " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " was bought out for $" . FJF_BASE::moneyFormat($notification["buy_now_price"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 20:
                  $notificationText = "You won " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " with a buy now purchase of $" . FJF_BASE::moneyFormat($notification["buy_now_price"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 21:
                  $notificationText = "The buyer's commission payment for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " failed. The buyer has been removed as the winning bidder. Relist auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/relist/";
                  break;
              case 22:
                  $notificationText = "Your commission payment for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " has failed. You have been removed as the winning bidder.";
                  break;
              case 23:
                  $notificationText = "Your credit card ending in " . $notification["cc_exp_number"]  . " is expiring on " . $notification["cc_exp_date"] . ". Please update your credit card before then to continue using Bid to Drive without interruption. Update account: " . $siteUrl . "/account/billing-details/";
                  break;
              case 24:
                  $notificationText = "Your credit card ending in " . $notification["cc_exp_number"] . " has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/billing-details/";
                  break;
              default:
                  $notificationText = "";
          }
        }else{
          switch ($notificationType) {
              case 1:
                  $notificationText = "Buyer registration confirmation";
                  break;
              case 2:
                  $notificationText = "You won " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " with a bid of $" . FJF_BASE::moneyFormat($notification["final_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 3:
                  $notificationText = "Your auction for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . "is complete with a winning bid of $" . FJF_BASE::moneyFormat($notification["final_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 4:
                  $notificationText = "Your watched listing ends in 24 hours: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 5:
                  $notificationText = "Your watched listing ends in 1 hour: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 6:
                  $notificationText = "Your watched listing ends in 5 minutes: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 7:
                  $notificationText = "You were outbid on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". The new high bid is $" . FJF_BASE::moneyFormat($notification["amount"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 8:
                  $notificationText = "New auction from " . $notification["seller_name"] . ": " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"];
                  break;
              case 9:
                  $notificationText = "Your listing ends in 24 hours: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 10:
                  $notificationText = "Your listing ends in 1 hour: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 11:
                  $notificationText = "Your listing ends in 5 minutes: " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". Current bid is $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 12:
                  $notificationText = "New bid on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " for $" . FJF_BASE::moneyFormat($notification["current_bid"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 13:
                  $notificationText = "Your auction for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " ended without meeting the reserve price. View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/. Relist auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/relist/. Accept High Bid: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/accept-highest-bid/";
                  break;
              case 14:
                  $notificationText = "Your dealer license expires soon on " . $notification["license_expiration_date"] . ". Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/";
                  break;
              case 15:
                  $notificationText = "Your driver's license expires soon on " . $notification["license_expiration_date"] . ". Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/buyer/";
                  break;
              case 16:
                  $notificationText = "Your driver's license has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/buyer/";
                  break;
              case 17:
                  $notificationText = "Your dealer license has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/";
                  break;
              case 18:
                  $notificationText = "You bid $" . FJF_BASE::moneyFormat($notification["amount"]) . " on " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 19:
                  $notificationText = "Your auction " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " was bought out for $" . FJF_BASE::moneyFormat($notification["buy_now_price"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 20:
                  $notificationText = "You won " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " with a buy now purchase of $" . FJF_BASE::moneyFormat($notification["buy_now_price"]) . ". View auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/";
                  break;
              case 21:
                  $notificationText = "The buyer's commission payment for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " failed. The buyer has been removed as the winning bidder. Relist auction: " . $siteUrl . "/auctions/" . $notification["auction_id"] . "/relist/";
                  break;
              case 22:
                  $notificationText = "Your commission payment for " . $notification["year"] . " " . $notification["make"] . " " . $notification["model"] . " has failed. You have been removed as the winning bidder.";
                  break;
              case 23:
                  $notificationText = "Your credit card ending in " . $notification["cc_exp_number"]  . " is expiring on " . $notification["cc_exp_date"] . ". Please update your credit card before then to continue using Bid to Drive without interruption. Update account: " . $siteUrl . "/account/billing-details/";
                  break;
              case 24:
                  $notificationText = "Your credit card ending in " . $notification["cc_exp_number"] . " has expired. Please update it on your account to continue using Bid to Drive. Update account: " . $siteUrl . "/account/billing-details/";
                  break;
              default:
                  $notificationText = "";
          }
        }

        return $notificationText;
    }
}

<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["app_web_path"] . "/resources/PHPMailer/class.phpmailer.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class MailModel
{

    static function getEmailTemplate($id)
    {
        if ($record = FJF_BASE_RICH::getRecords(
            "site_data",
            "type='email_templates' AND name='ID_VAL' LIMIT 1",
            array("ID_VAL" => $id),
            true,
            'data'
        )) {
            $tpl = json_decode($record->data);
            if ($tpl->body) return $tpl->body;
        }
        return null;
    }

    static function replaceVariables($replace, $content)
    {
        if ($replace && is_array($replace) && $content) {
            foreach ($replace as $search => $replacement) {
                if (array_key_exists($search, $replace)) $content = str_replace($search, $replacement, $content);
            }
        }
        return $content;
    }

    static function sendEmail($to, $subject, $message, $from, $fromName, $files = array())
    {

        $mail = new PHPMailer(true);

        $res = 0;
        try {
            //Server settings
            // $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'admin@bidtodrive.com';                     // SMTP username
            $mail->Password   = 'Leminh21';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;
            $mail->Encryption       = "TLS";                                    // TCP port to connect to

            //Recipients
            $mail->setFrom("noreply@bidtodrive.com", 'Noreply@bidtodrive.com');
            $mail->addAddress($to, 'You');

            // Content
            // $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->IsHTML(true);
            // echo $mailTo;die;
            $mail->send();
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // if ($to && $from && $message) {
        //
        //     $params = array(
        //         'from' => "noreply@bidtodrive.com",
        //         'fromname' => "Bid to Drive, LLC",
        //         'replyto' => "noreply@bidtodrive.com",
        //         'to' => $to,
        //         'subject' => $subject,
        //         'html' => $message,
        //         'x-smtpapi' => json_encode(array("to" => is_array($to) ? $to : array($to), "category" => $subject))
        //     );
        //
        //     if ($files) {
        //         foreach ($files as $filePath) {
        //             $params["files[" . basename($filePath) . "]"] = file_get_contents($filePath);
        //         }
        //     }
        //     $res = MailModel::call("mail", "send", $params);
        // }
        return $res;
    }

    private static function call($api, $method, array $data = array())
    {
        $data['api_user'] = $GLOBALS["WEB_APPLICATION_CONFIG"]["sendgrid"]["username"];
        $data['api_key'] = $GLOBALS["WEB_APPLICATION_CONFIG"]["sendgrid"]["password"];

        $ch = curl_init("https://sendgrid.com/api/" . $api . "." . $method . ".json");
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $body = curl_exec($ch);
        curl_close($ch);

        $response = $body ? json_decode($body) : null;


        if ($response) {
            if (isset($response->message) && $response->message == 'success') return $response;
            elseif (isset($response->errors) && $response->errors) $status = implode("\n", $response->errors);
            else $status = "Unknown error was happened.";
        } else $status = "The API call was unsuccessful.";

        throw new Exception($status);
    }

    static function getEmailData($id)
    {
        $record = FJF_BASE_RICH::getRecord("email_templates", "id='ID'", array("ID" => $id));
        if ($record) return $record;
        return null;
    }

    static function sendForgotPassword($user)
    {
        $template = MailModel::getEmailData(1);
        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user->name, ENT_QUOTES),
            "%EMAIL%" => htmlentities($user->email, ENT_QUOTES),
            "%LINK%" => "http://" . $_SERVER["SERVER_NAME"] . "/set-password/" . $user->password_refresh . urlencode(urlencode(FJF_BASE::encrypt($user->id, "refresh-password"))) . "/"
        ), $template->body);

        return self::sendEmail($user->email, $template->subject, $template->body);
    }

    static function sendConfirmMessageToUser($user)
    {
        $template = MailModel::getEmailData(2);
        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user["name"], ENT_QUOTES),
            "%EMAIL%" => htmlentities($user["email"], ENT_QUOTES),
            //"%LINK%" => "http://" . $_SERVER["SERVER_NAME"] . "/registration/verify/" . $user["verify_hash"]
        ),
            $template->body);
        return self::sendEmail($user["email"], $template->subject, $template->body, $user["email"], "Bid To Drive");
    }

    static function sendNotifyingMessageToAdmin($user)
    {
        $template = MailModel::getEmailData(1);

        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user["name"], ENT_QUOTES),
            "%EMAIL%" => htmlentities($user["email"], ENT_QUOTES),
            "%LINK%" => "http://" . $_SERVER["SERVER_NAME"] . "/registration/admin-verify/" . $user["verify_hash"]
        ),
            $template->body);

        $adminEmail = FJF_BASE_RICH::getRecords("site_vars", "name='admin_email' AND value<>'' LIMIT 1", null, true, "value");
        return self::sendEmail($adminEmail->value, $template->subject, $template->body, $user["email"], $user["name"]);
    }

    static function sendSuccessMessageToNewUser($user)
    {
        $template = MailModel::getEmailData(3);

        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user->name, ENT_QUOTES),
            "%EMAIL%" => htmlentities($user->email, ENT_QUOTES)
        ),
            $template->body);

        return self::sendEmail($user->email, $template->subject, $template->body, $user->email, $user->name);
    }

    static function sendRejectSellerRequest($user, $reason)
    {
        $template = MailModel::getEmailData(27);

        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user->name, ENT_QUOTES),
            "%EMAIL%" => htmlentities($user->email, ENT_QUOTES),
            "%REASON%" => htmlentities($reason, ENT_QUOTES),
        ),
            $template->body);

        return self::sendEmail($user->email, $template->subject, $template->body, $user->email, $user->name);
    }

    static function sendDeactiveUser($user, $reason)
    {
        $template = MailModel::getEmailData(28);

        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user->name, ENT_QUOTES),
            "%EMAIL%" => htmlentities($user->email, ENT_QUOTES),
            "%REASON%" => htmlentities($reason, ENT_QUOTES),
        ),
            $template->body);

        return self::sendEmail($user->email, $template->subject, $template->body, $user->email, $user->name);
    }

    static function sendEmailToSellerToAcceptHighestBid($user, $auction)
    {
        $template = MailModel::getEmailData(4);

        if (!$template) return false;

        $template->body = self::replaceVariables(array(
            "%NAME%" => htmlentities($user->name, ENT_QUOTES),
            "%EMAIL%" => htmlentities($user->email, ENT_QUOTES),
            "%AUCTION TITLE%" => $auction->make . " - " . $auction->model . " " . $auction->year,
            "%LINK RELIST%" => "http://" . $_SERVER["SERVER_NAME"] . "/auctions/" . $auction->id . "/relist/",
            "%LINK ACCEPT HIGHEST BID%" => "http://" . $_SERVER["SERVER_NAME"] . "/auctions/" . $auction->id . "/accept-highest-bid/"
        ), $template->body);

        $result = self::sendEmail($user->email, $template->subject, $template->body, $user->email, $user->name);

        return $result;
    }

    static function sendNotificationEmail($user, $notification)
    {
        if (is_object($user) && is_array($notification) && array_key_exists("notification", $notification)) {
            $siteUrl = "https://" . $_SERVER["SERVER_NAME"];
            $notificationData = json_decode($notification["notification"]);
            $variables = array(
                "%NAME%" => htmlentities($user->name, ENT_QUOTES),
                "%EMAIL%" => htmlentities($user->email, ENT_QUOTES),
                "%MAKE%" => (isset($notificationData->make)) ? $notificationData->make : "",
                "%MODEL%" => (isset($notificationData->model)) ? $notificationData->model : "",
                "%YEAR%" => (isset($notificationData->year)) ? $notificationData->year : "",
                "%TYPE_OF_LICENSE%" => (isset($notificationData->license_type)) ? $notificationData->license_type : "",
                "%LICENSE_EXPIRATION_DATE%" => (isset($notificationData->license_expiration_date)) ? date("F j, Y", strtotime($notificationData->license_expiration_date)) : "",
                "%STARTING_BID%" => (isset($notificationData->starting_bid)) ? FJF_BASE::moneyFormat($notificationData->starting_bid) : 0,
                "%CURRENT_BID%" => (isset($notificationData->current_bid)) ? FJF_BASE::moneyFormat($notificationData->current_bid) : 0,
                "%PREVIOUS_BID%" => (isset($notificationData->previous_bid)) ? FJF_BASE::moneyFormat($notificationData->previous_bid) : 0,
                "%FINAL_BID%" => (isset($notificationData->final_bid)) ? FJF_BASE::moneyFormat($notificationData->final_bid) : 0,
                "%WINNING_BID%" => (isset($notificationData->final_bid)) ? FJF_BASE::moneyFormat($notificationData->final_bid) : 0,
                "%BUYER_FEE%" => (isset($notificationData->buyer_fee)) ? FJF_BASE::moneyFormat($notificationData->buyer_fee) : 0,
                "%TOTAL_PRICE%" => (isset($notificationData->total_price)) ? FJF_BASE::moneyFormat($notificationData->total_price) : 0,
                "%BUY_NOW_PRICE%" => (isset($notificationData->buy_now_price)) ? FJF_BASE::moneyFormat($notificationData->buy_now_price) : 0,
                "%EXPIRATION_DATE%" => (isset($notificationData->expiration_date)) ? date("F j, Y", strtotime($notificationData->expiration_date)) : "",
                "%SELLER_NAME%" => (isset($notificationData->seller_name)) ? $notificationData->seller_name : "",
                "%SELLER_ADDRESS%" => (isset($notificationData->seller_address)) ? $notificationData->seller_address : "",
                "%SELLER_CITY%" => (isset($notificationData->seller_city)) ? $notificationData->seller_city : "",
                "%SELLER_STATE%" => (isset($notificationData->seller_state)) ? $notificationData->seller_state : "",
                "%SELLER_ZIP%" => (isset($notificationData->seller_zip)) ? $notificationData->seller_zip : "",
                "%SELLER_EMAIL%" => (isset($notificationData->seller_email)) ? $notificationData->seller_email : "",
                "%SELLER_PHONE%" => (isset($notificationData->seller_phone)) ? $notificationData->seller_phone : "",
                "%BUYER_NAME%" => (isset($notificationData->buyer_name)) ? $notificationData->buyer_name : "",
                "%BUYER_ADDRESS%" => (isset($notificationData->buyer_address)) ? $notificationData->buyer_address : "",
                "%BUYER_CITY%" => (isset($notificationData->buyer_city)) ? $notificationData->buyer_city : "",
                "%BUYER_STATE%" => (isset($notificationData->buyer_state)) ? $notificationData->buyer_state : "",
                "%BUYER_ZIP%" => (isset($notificationData->buyer_zip)) ? $notificationData->buyer_zip : "",
                "%BUYER_EMAIL%" => (isset($notificationData->buyer_email)) ? $notificationData->buyer_email : "",
                "%BUYER_PHONE%" => (isset($notificationData->buyer_phone)) ? $notificationData->buyer_phone : "",
                "%BILL_OF_SALE_LINK%" => (isset($notificationData->auction_id)) ? $siteUrl . "/auctions/" . $notificationData->auction_id . "/bill/" : "",
                "%AUCTION_LINK%" => (isset($notificationData->auction_id)) ? $siteUrl . "/auctions/" . $notificationData->auction_id . "/" : "",
                "%RELIST_LINK%" => (isset($notificationData->auction_id)) ? $siteUrl . "/auctions/" . $notificationData->auction_id . "/relist/" : "",
                "%ACCEPT_HIGHEST_BID_LINK%" => (isset($notificationData->auction_id)) ? $siteUrl . "/auctions/" . $notificationData->auction_id . "/accept-highest-bid/" : "",
                "%AUCTION_ID%" => (isset($notificationData->auction_id)) ? $notificationData->auction_id : "",
                "%TIME_OF_FAILURE%" => (isset($notificationData->time_of_failure)) ? date("F j, Y h:i A", strtotime($notificationData->time_of_failure)) : "",
                "%CC_LAST_FOUR_DIGITS%" => (isset($notificationData->cc_exp_number)) ? $notificationData->cc_exp_number : "",
                "%CC_EXPIRATION_DATE%" => (isset($notificationData->cc_exp_date)) ? date("F j, Y", strtotime($notificationData->cc_exp_date)) : "",
            );

            $template = null;
            if ($notification["type"] == NotificationModel::TYPE_BUYER_WINS_AUCTION) {
                $template = MailModel::getEmailData(5);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_AUCTION_COMPLETES_SUCCESSFULLY) {
                $template = MailModel::getEmailData(12);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_LISTING_EXPIRING_24HOURS) {
                $template = MailModel::getEmailData(8);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_LISTING_EXPIRING_1HOUR) {
                $template = MailModel::getEmailData(18);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_LISTING_EXPIRING_5MINUTES) {
                $template = MailModel::getEmailData(19);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_BID_PLACED) {
                $template = MailModel::getEmailData(13);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_LISTING_EXPIRING_24HOURS) {
                $template = MailModel::getEmailData(11);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_LISTING_EXPIRING_1HOUR) {
                $template = MailModel::getEmailData(16);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_LISTING_EXPIRING_5MINUTES) {
                $template = MailModel::getEmailData(17);
            } elseif ($notification["type"] == NotificationModel::TYPE_DEALER_LICENSE_EXPIRES || $notification["type"] == NotificationModel::TYPE_DRIVER_LICENSE_EXPIRES) {
                $template = MailModel::getEmailData(14);
            } elseif ($notification["type"] == NotificationModel::TYPE_DRIVER_LICENSE_EXPIRED || $notification["type"] == NotificationModel::TYPE_DEALER_LICENSE_EXPIRED) {
                $template = MailModel::getEmailData(15);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_BUY_NOW) {
                $template = MailModel::getEmailData(6);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_BUY_NOW) {
                $template = MailModel::getEmailData(7);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_OUTBID_AUCTION) {
                $template = MailModel::getEmailData(9);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_NEW_AUCTION_FROM_WATCHED_SELLER) {
                $template = MailModel::getEmailData(10);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_LISTING_ENDED_WITHOUT_MEETING_RESERVE) {
                $template = MailModel::getEmailData(20);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_BID_PLACED) {
                $template = MailModel::getEmailData(21);
            } elseif ($notification["type"] == NotificationModel::TYPE_SELLER_PAYMENT_FAILURE) {
                $template = MailModel::getEmailData(22);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_PAYMENT_FAILURE) {
                $template = MailModel::getEmailData(23);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_CC_EXPIRES) {
                $template = MailModel::getEmailData(25);
            } elseif ($notification["type"] == NotificationModel::TYPE_BUYER_CC_EXPIRED) {
                $template = MailModel::getEmailData(26);
            }

            if (!empty($template)) {
                $template->subject = self::replaceVariables($variables, $template->subject);
                $template->body = self::replaceVariables($variables, $template->body);
                self::sendEmail($user->email, $template->subject, $template->body, $user->email, $user->name);
            }
        }
        return true;
    }

    static function sendAdminFailedCommissionEmail($notification)
    {
        if (is_array($notification)) {
            $siteUrl = "https://" . $_SERVER["SERVER_NAME"];
            $notificationData = json_decode($notification["notification"]);
            $variables = array(
                "%MAKE%" => (isset($notificationData->make)) ? $notificationData->make : "",
                "%MODEL%" => (isset($notificationData->model)) ? $notificationData->model : "",
                "%YEAR%" => (isset($notificationData->year)) ? $notificationData->year : "",
                "%WINNING_BID%" => (isset($notificationData->final_bid)) ? FJF_BASE::moneyFormat($notificationData->final_bid) : 0,
                "%BUYER_FEE%" => (isset($notificationData->buyer_fee)) ? FJF_BASE::moneyFormat($notificationData->buyer_fee) : 0,
                "%SELLER_NAME%" => (isset($notificationData->seller_name)) ? $notificationData->seller_name : "",
                "%BUYER_NAME%" => (isset($notificationData->buyer_name)) ? $notificationData->buyer_name : "",
                "%AUCTION_LINK%" => (isset($notificationData->auction_id)) ? $siteUrl . "/auctions/" . $notificationData->auction_id . "/" : "",
                "%AUCTION_ID%" => (isset($notificationData->auction_id)) ? $notificationData->auction_id : "",
                "%TIME_OF_FAILURE%" => (isset($notificationData->time_of_failure)) ? date("F j, Y h:i A", strtotime($notificationData->time_of_failure)) : "",
            );

            $template = MailModel::getEmailData(24);
            if (!empty($template)) {
                $template->subject = self::replaceVariables($variables, $template->subject);
                $template->body = self::replaceVariables($variables, $template->body);
                $adminEmail = FJF_BASE_RICH::getRecords("site_vars", "name='admin_email' AND value<>'' LIMIT 1", null, true, "value");
                if (is_object($adminEmail)) {
                    self::sendEmail($adminEmail->value, $template->subject, $template->body, $GLOBALS["WEB_APPLICATION_CONFIG"]["from"]["address"], $GLOBALS["WEB_APPLICATION_CONFIG"]["from"]["name"]);
                }
            }
        }
        return true;
    }
}

?>

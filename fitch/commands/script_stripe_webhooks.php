<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mandrill_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");

class ScriptStripeWebhooks extends FJF_CMD
{
    function execute()
    {
        if ($_SERVER["REQUEST_METHOD"] == "HEAD") {
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            StripeModel::setApiKey();
            $webhookResponse = json_decode(file_get_contents("php://input"));
            $webhookResponseTypes = array(
                "invoice.payment_failed",
                "charge.succeeded",
                "charge.refunded"
            );

            //$webhookLogFile = $_SERVER["DOCUMENT_ROOT"] . "/data/webhook.log";
            //file_put_contents($webhookLogFile, "DATE: " . date("Y-m-d H:i:s") . " \n-----------------\n", FILE_APPEND);
            //file_put_contents($webhookLogFile, print_r($webhookResponse, 1) . "\n-----------------\n", FILE_APPEND);

            if (in_array($webhookResponse->type, $webhookResponseTypes)) {
                if ($user = FJF_BASE_RICH::getRecord("users", "stripe_customer_id = 'CUSTOMER_ID_VAL'", array(
                    "CUSTOMER_ID_VAL" => $webhookResponse->data->object->customer
                ))) {
                    if ($webhookResponse->type == "invoice.payment_failed") {
                        //$webhookResponse->data->object->customer = 'cus_8zE4Qr9mUVhGFV';
                        //$webhookResponse->data->object->subscription = 'sub_8zE4JCFT7VPwMQ';
                        if ($user->stripe_subscription_id == $webhookResponse->data->object->subscription) {
                            $hasError = false;
                            if ($user->stripe_subscription_id) {
                                try {
                                    StripeModel::cancelCustomerSubscribe($user->stripe_customer_id, $user->stripe_subscription_id);
                                } catch (Exception $e) {
                                    $hasError = true;
                                }
                            }
                            if (!$hasError) {
                                if (FJF_BASE_RICH::saveRecord("users", array(
                                    "id" => $user->id,
                                    "stripe_subscription_id" => ""
                                ))) {
                                    $mandrillModel = new MandrillModel();
                                    $mandrillModel->sendFailedPayment(array(
                                        "user_name" => $user->name,
                                        "user_email" => $user->email
                                    ));
                                    if ($contactEmail = RecordsModel::getSiteVar("contact_email")) {
                                        $emails = explode(",", $contactEmail);
                                        foreach ($emails as $email) {
                                            $mandrillModel->sendFailedPayment(array(
                                                "recipient_name" => "",
                                                "recipient_email" => $email,
                                                "user_name" => $user->name,
                                                "user_email" => $user->email
                                            ));
                                        }
                                    }
                                }
                            }
                        }
                    } elseif ($webhookResponse->type == "charge.succeeded") {
                        FJF_BASE_RICH::saveRecord("users_payments", array(
                            "user_id" => $user->id,
                            "amount" => number_format(($webhookResponse->data->object->amount / 100), 2, ".", ""),
                            "date" => date("Y-m-d H:i:s")
                        ));
                    } elseif ($webhookResponse->type == "charge.refunded") {
                        FJF_BASE_RICH::saveRecord("users_payments", array(
                            "user_id" => $user->id,
                            "amount" => -1 * number_format(($webhookResponse->data->object->amount_refunded / 100), 2, ".", ""),
                            "date" => date("Y-m-d H:i:s")
                        ));
                    }
                }
            }
        }
        exit;
    }
}

?>
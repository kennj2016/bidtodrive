<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");

class AccountBuyerBillingDetails extends FJF_CMD
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
            $fields["email"] = $user->email;
            $stripeToken = (isset($_POST["stripe_id"])) ? trim($_POST["stripe_id"]) : "";
            $stripeCustomerID = $user->stripe_id;

            $fields["cc_exp_month"] = (isset($_POST["card_month"])) ? trim($_POST["card_month"]) : "";
            $fields["cc_exp_year"] = (isset($_POST["card_year"])) ? trim($_POST["card_year"]) : "";
            if (!$hasError) {
                if ($stripeToken != "") {
                    try {
                        \Stripe\Stripe::setVerifySslCerts(false);
                        StripeModel::setApiKey();
                        if ($stripeCustomerID != "") {
                            $fields["stripe_id"] = $stripeCustomerID;
                            StripeModel::updateCustomer($stripeCustomerID, $stripeToken, null, []);
                        } else {
                            $fields["stripe_id"] = StripeModel::createCustomer($stripeToken, $fields["email"], []);
                        }
                        $fields["cc_expired"] = 0;
                    } catch (Exception $e) {
                        $hasError = true;
                        $response["status"] = $e->getMessage();
                    }
                }
                if ($stripeCustomerID != "") {
                    StripeModel::setApiKey();
                    $stripeCustomerInfo = StripeModel::getCustomer($stripeCustomerID);
                    $fields["cc_exp_number"] = $stripeCustomerInfo["sources"]->data[0]->last4;
                    $fields["cc_exp_name"] = $stripeCustomerInfo["sources"]->data[0]->name;
                }

                if (!$hasError && FJF_BASE_RICH::updateRecord("users", $fields, "id")) {
                    $response["status"] = true;

                }
            }
        }

        $this->pageModel->setMetadata("title", "Billing Details");

        return $this->displayTemplate("account_buyer_billing_details.tpl", array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
        ));
    }

}

?>

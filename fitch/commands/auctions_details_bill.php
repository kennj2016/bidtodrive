<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class AuctionsDetailsBill extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        $this->sessionModel->requireUser();
    }

    function execute()
    {
        $userID = SessionModel::loggedUserID();
        $userType = SessionModel::getUserType();
        if (!in_array($userType, array("Seller", "Buyer"))) {
            FJF_BASE::redirect("/auctions/");
        }

        $auctionID = isset($_REQUEST["id"]) ? trim($_REQUEST["id"]) : "";
        $where = "a.id = " . $auctionID;
        $having = "";
        if ($userType == "Seller") {
            $where .= " AND a.user_id = '" . $userID . "'";
        } elseif ($userType == "Buyer") {
            $having .= "(winning_user_id ='" . $userID . "')";
        }
        $record = RecordsModel::getAllAuctions($where, $having);
        $auctionInfo = $record[0];
        if (!$auctionInfo) {
            FJF_BASE::redirect("/auctions/");
        }
        $payment = FJF_BASE_RICH::getRecord("transactions", "auction_id = 'AUCTION_ID'", array('AUCTION_ID' => $auctionID));
        if(is_object($payment)){
            $auctionInfo->refund_amount = $payment->refund_amount;
        }else{
            $auctionInfo->refund_amount = "";
        }
        /*
        if (!is_object($payment)) {
            FJF_BASE::redirect("/auctions/");
        }
        */
        if (is_object($payment)) {
            $auctionInfo->fee_formatted = FJF_BASE::moneyFormat($payment->buyer_fee);
            $auctionInfo->total = $payment->sale_price + $payment->buyer_fee;
            $auctionInfo->current_bid_price = FJF_BASE::moneyFormat($payment->sale_price);
        }

        if ($auctionInfo->terms_condition_id > 0) {
            $CBTerms = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'TERM_ID'", array("TERM_ID" => $auctionInfo->terms_condition_id));
            $auctionInfo->terms_conditions = $CBTerms->description;
        }

        if ($auctionInfo->additional_fees_id > 0) {
            $CBFees = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'AF_ID'", array("AF_ID" => $auctionInfo->additional_fees_id));
            $auctionInfo->additional_fees = $CBFees->description;
        }

        $CBPaymentPickup = ($auctionInfo->payment_pickup_id > 0) ? FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'PP_ID'", array("PP_ID" => $auctionInfo->payment_pickup_id)) : null;

        if ($userType == "Seller") {
            $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $userID);
            $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $auctionInfo->winning_user_id);
        } elseif ($userType == "Buyer") {
            $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $auctionInfo->user_id);
            $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $userID);
        }
        $auctionInfo->discount = FJF_BASE::moneyFormat($payment->discount);
        $auctionInfo->price_all = FJF_BASE::moneyFormat($payment->price_all);
        $auctionInfo->pickup_transporter = is_object($buyerInfo) && isset($buyerInfo->pickup_transporter) && $buyerInfo->pickup_transporter != "" ? $buyerInfo->pickup_transporter : "";
        $auctionInfo->pickup_address = is_object($buyerInfo) && isset($buyerInfo->pickup_address) && $buyerInfo->pickup_address != "" ? $buyerInfo->pickup_address : "";
        $auctionInfo->pickup_city = is_object($buyerInfo) && isset($buyerInfo->pickup_city) && $buyerInfo->pickup_city != "" ? $buyerInfo->pickup_city : "";
        $auctionInfo->pickup_state = is_object($buyerInfo) && isset($buyerInfo->pickup_state) && $buyerInfo->pickup_state != "" ? $buyerInfo->pickup_state : "";
        $auctionInfo->pickup_zip = is_object($buyerInfo) && isset($buyerInfo->pickup_zip) && $buyerInfo->pickup_zip != "" ? $buyerInfo->pickup_zip : "";
        $auctionInfo->transporter_phone = is_object($buyerInfo) && isset($buyerInfo->transporter_phone) && $buyerInfo->transporter_phone != "" ? $buyerInfo->transporter_phone : "";
        $auctionInfo->pickup_driver = is_object($buyerInfo) && isset($buyerInfo->pickup_driver) && $buyerInfo->pickup_driver != "" ? $buyerInfo->pickup_driver : "";
        $auctionInfo->driver_phone = is_object($buyerInfo) && isset($buyerInfo->driver_phone) && $buyerInfo->driver_phone != "" ? $buyerInfo->driver_phone : "";

        if (!empty($CBPaymentPickup)) {
            $tmpPaymentMethods = array();
            $paymentMethods = explode(",", $CBPaymentPickup->payment_method);
            if (!empty($paymentMethods)) {
                foreach ($paymentMethods as $paymentMethod) {
                    if (array_key_exists($paymentMethod, $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"])) {
                        $tmpPaymentMethods[] = $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"][$paymentMethod];
                    }
                }
            }
            $auctionInfo->payment_method = implode(", ", $tmpPaymentMethods);
            $auctionInfo->pickup_window = isset($CBPaymentPickup->pickup_window) && $CBPaymentPickup->pickup_window != "" ? $CBPaymentPickup->pickup_window : "";
            $auctionInfo->pickup_note = isset($CBPaymentPickup->pickup_note) && $CBPaymentPickup->pickup_note != "" ? $CBPaymentPickup->pickup_note : "";
        } else {
            $auctionInfo->payment_method = $auctionInfo->payment_method;
            $auctionInfo->pickup_window = $auctionInfo->pickup_window;
            $auctionInfo->pickup_note = $auctionInfo->pickup_note;
        }

        $auctionInfo->meta_title = $auctionInfo->year . " " . $auctionInfo->make . " " . $auctionInfo->model;
        $auctionInfo->meta_keywords = "";
        $auctionInfo->meta_description = $auctionInfo->description;

        $swipeboxItems = [];
        if (!empty($auctionInfo->photos)) {
            foreach ($auctionInfo->photos as $auctionPhotoKey => $auctionPhoto) {
                $swipeboxItems[$auctionPhotoKey]["href"] = "/site_media/" . $auctionPhoto->photo . "/l/";
            }
        }

        $this->pageModel->extractMetadata($auctionInfo);

        $templateParams = array(
            "auction_info" => $auctionInfo,
            "seller_info" => $sellerInfo,
            "buyer_info" => $buyerInfo,
            "logged_user_type" => $userType,
            "swipebox_items" => json_encode($swipeboxItems)
        );
        return $this->displayTemplate("auctions_details_bill.tpl", $templateParams);
    }

}

?>

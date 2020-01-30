<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");

class AdminTransactionsView extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Transactions');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $transactionID = isset($_REQUEST["id"]) ? trim($_REQUEST["id"]) : "";
        if ($transactionID != "") {
            $record = FJF_BASE_RICH::getRecord("transactions", "id = 'TRANSACTION_ID'", array("TRANSACTION_ID" => $transactionID));
            if (!$record) {
                $header["return"] = "/admin/transactions/";
            }
        }

        $auctionInfo = FJF_BASE_RICH::getRecord("auctions", "id = 'AUCTION_ID'", array("AUCTION_ID" => $record->auction_id));
        if ($auctionInfo->payment_pickup_id > 0) {
            $paymentPickup = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'PP_ID' AND type = 'Payment/Pickup'", array("PP_ID" => $auctionInfo->payment_pickup_id));
            $record->transporter = is_object($paymentPickup) ? $paymentPickup->pickup_note : "";
        } else {
            $record->transporter = $auctionInfo->pickup_transporter;
        }
        if ($auctionInfo->terms_condition_id > 0) {
            $termsConditions = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'TC_ID' AND type = 'Terms & Conditions'", array("TC_ID" => $auctionInfo->terms_condition_id));
            $record->terms_conditions = $termsConditions->description;
        } else {
            $record->terms_conditions = $auctionInfo->terms_conditions;
        }
        if ($auctionInfo->additional_fees_id > 0) {
            $additionalFees = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'AF_ID' AND type = 'Additional Fees'", array("AF_ID" => $auctionInfo->additional_fees_id));
            $record->additional_fees = $additionalFees->description;
        } else {
            $record->additional_fees = $auctionInfo->additional_fees;
        }
        $record->purchasing_agreement = "";

        $hasError = false;
        $status = "";
        $action = isset($_REQUEST["action"]) ? trim($_REQUEST["action"]) : "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($action == "refund") {
                if ($record->stripe_charge_id) {
                    try {
                        $refundAmount = (isset($_POST["refund_amount"]) && floatval($_POST["refund_amount"]) > 0 && floatval($_POST["refund_amount"]) <= (floatval($record->buyer_fee) - floatval($record->refund_amount))) ? floatval($_POST["refund_amount"]) : 0;
                        if ($refundAmount > 0) {
                            StripeModel::setApiKey();
                            $refundID = StripeModel::createRefund($record->stripe_charge_id, array("amount" => $refundAmount * 100));
                            if ($refundID != "") {
                                $record->status = "refunded";
                                $record->stripe_refund_id = $refundID;

                                $success = FJF_BASE_RICH::updateRecord("transactions", array(
                                    "id" => $record->id,
                                    "status" => $record->status,
                                    "stripe_refund_id" => $refundID,
                                    "refund_amount" => ($refundAmount + $record->refund_amount)
                                ), "id");

                                if ($success) {
                                    $editorParams = array(
                                        "id" => $record->auction_id,
                                        "table" => "auctions",
                                        "title_field" => "title",
                                        "positions" => true
                                    );
                                    $editor = new AdminEditRevisionsModel($editorParams);
                                    $auction = $editor->loadRecord();
                                    if (is_object($auction)) {
                                        $auction->auction_status = "Refunded";
                                        $editor->saveAndPublish();
                                    }
                                }

                                FJF_BASE::redirect("/admin/transactions/" . $transactionID . "/");
                            }
                        } else {
                            $hasError = true;
                            $status .= "Invalid Refund Amount";
                        }
                    } catch (Exception $e) {
                        $hasError = true;
                        $status .= $e->getMessage();
                    }
                }
            }
        }

        $this->setRecord($record);

        return $this->displayTemplate("admin_transactions_view.tpl", array(
            "header" => $header,
            "record" => $record,
            "status" => $status,
            "has_error" => $hasError
        ));
    }

}

?>
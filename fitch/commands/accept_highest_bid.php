<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class AcceptHighestBid extends FJF_CMD
{
    var $sessionModel = null;
    var $notificationModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->notificationModel = new NotificationModel();
        $this->pageModel = new PageModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $userID = SessionModel::loggedUserID();
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);

        $auctionID = isset($_REQUEST["id"]) ? trim($_REQUEST["id"]) : "";
        $auction = FJF_BASE_RICH::getRecordBy("auctions", $auctionID);
        $acceptLinkSentDate = is_object($auction) ? strtotime($auction->accept_link_sent) + 172800 : 0; //172800 - 48 hours in seconds

        if($auction && is_object($auction) && (time() < $acceptLinkSentDate) && $auction->auction_status == "Unsold" && $auction->disallow_accept_highest_bid != 1){
            $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $auction->user_id);
            if ($sellerInfo && is_object($sellerInfo) && $sellerInfo->user_type == "Seller" && $_SESSION["user"]->id == $auction->user_id) {
                $siteCommission = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_commission' AND value<>'' LIMIT 1", null, true, "value");
                $buyerFeeCap = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_cap' AND value<>'' LIMIT 1", null, true, "value");
                $adminInfo = FJF_BASE_RICH::getRecordBy("users", 1);
                $editorParams = array(
                    "table" => "auctions",
                    "title_field" => "title",
                    "positions" => true,
                    "id" => $auction->id,
                    "user" => $adminInfo
                );
                $editor = new AdminEditRevisionsModel($editorParams);
                $record = $editor->loadRecord();
                $maxBidObj = FJF_BASE_RICH::getRecords("auctions_bids", "auction_id = " . $auction->id . " AND bid_price=(SELECT MAX(bid_price) FROM auctions_bids WHERE auction_id = " . $auction->id . ")", [], true, "id, user_id, bid_price");
                if (is_object($maxBidObj)) {
                    $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $maxBidObj->user_id);
                    if (is_object($buyerInfo) && $buyerInfo->stripe_id != "") {
                        $code = '';
                        if($buyerInfo->discount_code != ''){
                            $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $buyerInfo->discount_code,'STATUS' => 1));
                        }
                        $this_price = $maxBidObj->bid_price;
                        $this_discount = 0;

                        if($code && $code != ''){
                            if($code->type == 1){
                              $this_discount= (floatval($maxBidObj->bid_price) * intval($code->percent)/100);
                              $maxBidObj->bid_price = floatval($maxBidObj->bid_price) - (floatval($maxBidObj->bid_price) * intval($code->percent)/100);
                            }else{
                              $this_discount= intval($code->price);
                              $maxBidObj->bid_price = floatval($maxBidObj->bid_price) - intval($code->price);
                            }
                        }

                        StripeModel::setApiKey();
                        $buyerFee = floatval($siteCommission->value * $maxBidObj->bid_price / 100);
                        $uniqueBuyerFee = floatval($buyerInfo->buyer_fee * $maxBidObj->bid_price / 100);
                        if (is_object($buyerFeeCap) && floatval($buyerFeeCap->value) > 0 && floatval($buyerFeeCap->value) < $buyerFee) {
                            $transaction["buyer_fee"] = $buyerFeeAmount = floatval($buyerFeeCap->value);
                        } else {
                            if(is_object($buyerInfo) && isset($buyerInfo->buyer_fee) && $buyerInfo->buyer_fee > 0){
                                $transaction["buyer_fee"] = $buyerFeeAmount = $uniqueBuyerFee;
                            }else{
                                $transaction["buyer_fee"] = $buyerFeeAmount = $buyerFee;
                            }
                        }




                        $transaction["stripe_charge_id"] = StripeModel::createCharge($buyerInfo->stripe_id, $transaction["buyer_fee"]);
                        if ($transaction["stripe_charge_id"] != "") {
                            $transaction["auction_id"] = $auction->id;
                            $transaction["auction_name"] = ($auction->title != "") ? $auction->title : $auction->year . " " . $auction->make . " " . $auction->model;
                            $transaction["buyer_id"] = $buyerInfo->id;
                            $transaction["buyer_name"] = $buyerInfo->name;
                            $transaction["buyer_email"] = $buyerInfo->email;
                            $transaction["buyer_phone"] = $buyerInfo->mobile_number;
                            $transaction["buyer_address"] = $buyerInfo->address;
                            $transaction["buyer_city"] = $buyerInfo->city;
                            $transaction["buyer_state"] = $buyerInfo->state;
                            $transaction["buyer_zip"] = $buyerInfo->zip;
                            $transaction["seller_id"] = $auction->user_id;
                            $transaction["seller_name"] = (is_object($sellerInfo)) ? $sellerInfo->name : "";
                            $transaction["seller_email"] = (is_object($sellerInfo)) ? $sellerInfo->email : "";
                            $transaction["seller_phone"] = (is_object($sellerInfo)) ? $sellerInfo->mobile_number : "";
                            $transaction["seller_address"] = (is_object($sellerInfo)) ? $sellerInfo->address : "";
                            $transaction["seller_city"] = (is_object($sellerInfo)) ? $sellerInfo->city : "";
                            $transaction["seller_state"] = (is_object($sellerInfo)) ? $sellerInfo->state : "";
                            $transaction["seller_zip"] = (is_object($sellerInfo)) ? $sellerInfo->zip : "";
                            $transaction["purchasing_agreement"] = "";
                            $transaction["discount"] = $this_discount;
                            $transaction["price_all"] = $this_price;
                            $transaction["sale_price"] = floatval($maxBidObj->bid_price);
                            $transaction["datetime"] = date("Y-m-d H:i:s");
                            FJF_BASE_RICH::insertRecord("transactions", $transaction);
                            FJF_BASE_RICH::saveRecord("auctions_bids", ["id" => $maxBidObj->id, "winning_bid" => 1]);
                            $record->auction_status = "Sold";
                            $record->auction_completion_date = date("Y-m-d H:i:s");
                            $editor->saveAndPublish();

                            // BUYER WINS AUCTION
                            $notificationData["type"] = NotificationModel::TYPE_BUYER_WINS_AUCTION;
                            $notificationData["uid"] = $buyerInfo->uid;
                            $notificationData["notification"] = json_encode([
                                "auction_id" => $auction->id,
                                "make" => $auction->make,
                                "model" => $auction->model,
                                "year" => $auction->year,
                                "final_bid" => $transaction["sale_price"],
                                "buyer_fee" => $transaction["buyer_fee"],
                                "total_price" => ($transaction["sale_price"] + $transaction["buyer_fee"]),
                                "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                "seller_address" => (is_object($sellerInfo)) ? $sellerInfo->address : "",
                                "seller_city" => (is_object($sellerInfo)) ? $sellerInfo->city : "",
                                "seller_state" => (is_object($sellerInfo)) ? $sellerInfo->state : "",
                                "seller_zip" => (is_object($sellerInfo)) ? $sellerInfo->zip : "",
                                "seller_email" => (is_object($sellerInfo)) ? $sellerInfo->email : "",
                                "seller_phone" => (is_object($sellerInfo)) ? $sellerInfo->mobile_number : ""
                            ]);
                            $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                            // SELLER AUCTION COMPLETES SUCCESSFULLY
                            $notificationData["type"] = NotificationModel::TYPE_SELLER_AUCTION_COMPLETES_SUCCESSFULLY;
                            $notificationData["uid"] = $sellerInfo->uid;
                            $notificationData["notification"] = json_encode([
                                "auction_id" => $auction->id,
                                "make" => $auction->make,
                                "model" => $auction->model,
                                "year" => $auction->year,
                                "final_bid" => $transaction["sale_price"],
                                "buyer_name" => $transaction["buyer_name"],
                                "buyer_address" => $transaction["buyer_address"],
                                "buyer_city" => $transaction["buyer_city"],
                                "buyer_state" => $transaction["buyer_state"],
                                "buyer_zip" => $transaction["buyer_zip"],
                                "buyer_email" => $transaction["buyer_email"],
                                "buyer_phone" => $transaction["buyer_phone"]
                            ]);
                            $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                            if($code && $code != ''){
                              $code = FJF_BASE_RICH::updateRecord("coupon", ["id" => $code->id, "`limit`" => intval($code->limit) - 1], "id");
                            }

                        } else {
                            $record->auction_status = "Canceled";
                            $record->auction_completion_date = date("Y-m-d H:i:s");
                            $editor->saveAndPublish();
                        }

                        if ($record->auction_status == "Canceled") {
                            // SELLER - FAILED COMMISSION PAYMENT
                            $notificationData["type"] = NotificationModel::TYPE_SELLER_PAYMENT_FAILURE;
                            $notificationData["uid"] = $sellerInfo->uid;
                            $notificationData["notification"] = json_encode([
                                "auction_id" => $auction->id,
                                "make" => $auction->make,
                                "model" => $auction->model,
                                "year" => $auction->year,
                                "final_bid" => floatval($maxBidObj->bid_price),
                                "buyer_fee" => $buyerFeeAmount,
                                "total_price" => (floatval($maxBidObj->bid_price) + $buyerFeeAmount),
                                "buyer_name" => $buyerInfo->name,
                                "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                "time_of_failure" => date("Y-m-d H:i:s")
                            ]);
                            $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);

                            // BUYER - FAILED COMMISSION PAYMENT
                            $notificationData["type"] = NotificationModel::TYPE_BUYER_PAYMENT_FAILURE;
                            $notificationData["uid"] = $buyerInfo->uid;
                            $notificationData["notification"] = json_encode([
                                "auction_id" => $auction->id,
                                "make" => $auction->make,
                                "model" => $auction->model,
                                "year" => $auction->year,
                                "final_bid" => floatval($maxBidObj->bid_price),
                                "buyer_fee" => $buyerFeeAmount,
                                "total_price" => (floatval($maxBidObj->bid_price) + $buyerFeeAmount),
                                "buyer_name" => $buyerInfo->name,
                                "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                "time_of_failure" => date("Y-m-d H:i:s")
                            ]);
                            $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                            MailModel::sendAdminFailedCommissionEmail($notificationData);
                        }
                    } else {
                        $record->auction_status = "Canceled";
                        $record->auction_completion_date = date("Y-m-d H:i:s");
                        $editor->saveAndPublish();
                    }
                }
                unset($record);
                unset($editor);
            }

            FJF_BASE::redirect("/auctions/" . $auctionID . "/");
        }else{
            $error = "Option to accept the highest bid has expired.";
            $templateParams = array(
                "error" => $error,
                "user" => $user
            );
            return $this->displayTemplate("accept_highest_bid.tpl", $templateParams);
        }
    }
}

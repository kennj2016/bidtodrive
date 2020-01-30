<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");

class AjaxAuctionsBuyNow extends FJF_CMD
{
    var $sessionModel = null;
    var $notificationModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->notificationModel = new NotificationModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $output["status"] = "";
        $output["redirect"] = "";

        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $discount = 0 ;
            if(@$_GET["code"] != ''){
                $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $_GET["code"],'STATUS' => 1));
                if($code){
                      $auctionID = (isset($_POST["auction_id"])) ? intval($_POST["auction_id"]) : 0;
                      $auctionBuyNowInProgress = (isset($_SESSION["buy_now_in_progress"])) ? $_SESSION["buy_now_in_progress"] : 0;
                      $buyerID = SessionModel::loggedUserID();
                      $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $buyerID);

                      if ($buyerInfo->license_expired == 1) {
                          $output["status"] = "Your license is expired. Please renew your license and update your account to continue.";
                      } elseif ($auctionID > 0 ) {
                          $_SESSION["buy_now_in_progress"] = $auctionID;
                          $editorParams = array(
                              "table" => "auctions",
                              "title_field" => "title",
                              "positions" => true,
                              "id" => $auctionID
                          );
                          $editor = new AdminEditRevisionsModel($editorParams);
                          $record = $editor->loadRecord();
                          $this_price = $record->buy_now_price;
                          $this_discount = 0;
                          if($code->type == 1){
                            $this_discount= (floatval($record->buy_now_price) * intval($code->percent)/100);
                            $record->buy_now_price = floatval($record->buy_now_price) - (floatval($record->buy_now_price) * intval($code->percent)/100);
                          }else{
                            $this_discount= intval($code->price);
                            $record->buy_now_price = floatval($record->buy_now_price) - intval($code->price);
                          }
                          // print_r($record);die;
                          // $record =  FJF_BASE_RICH::getRecord("auctions", "id = ".$auctionID."  limit 1", array());
                          if (is_object($record) && ($record->id == $auctionID) && $record->buy_now_price > 0 && ($record->auction_status == "Active" || $record->status == 1) && (time() < strtotime($record->expiration_date)) && (is_object($buyerInfo) && $buyerInfo->user_type == "Buyer")) {
                              if (!$buyerInfo->stripe_id) {
                                  $output["status"] = "Please add credit card and billing information to your account before placing a bid." . " <a class='update-cc' href='/account/billing-details/'>Update now</a>";
                              } else {
                                  \Stripe\Stripe::setVerifySslCerts(false);
                                  StripeModel::setApiKey();
                                  $stripeCustomerInfo = StripeModel::getCustomer($buyerInfo->stripe_id);
                                  $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $record->user_id);
                                  if (is_object($stripeCustomerInfo)) {
                                      // Transaction Insertion
                                      $siteCommission = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_commission' LIMIT 1", null, true, "value");
                                      $buyerFeeCap = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_cap' AND value<>'' LIMIT 1", null, true, "value");
                                      $buyerFee = floatval($siteCommission->value * floatval($record->buy_now_price) / 100);
                                      $uniqueBuyerFee = floatval($buyerInfo->buyer_fee * floatval($record->buy_now_price) / 100);
                                      if (is_object($buyerFeeCap) && floatval($buyerFeeCap->value) > 0 && floatval($buyerFeeCap->value) < $buyerFee) {
                                          $transaction["buyer_fee"] = floatval($buyerFeeCap->value);
                                      } else {
                                          if(isset($buyerInfo->buyer_fee) && $buyerInfo->buyer_fee > 0){
                                              $transaction["buyer_fee"] = $uniqueBuyerFee;
                                          }else{
                                              $transaction["buyer_fee"] = $buyerFee;
                                          }
                                      }
                                      $transaction["stripe_charge_id"] = StripeModel::createCharge($buyerInfo->stripe_id, $transaction["buyer_fee"]);
                                      if ($transaction["stripe_charge_id"] != "") {
                                          $transaction["auction_id"] = $record->id;
                                          $transaction["auction_name"] = ($record->title != "") ? $record->title : $record->year . " " . $record->make . " " . $record->model;
                                          $transaction["buyer_id"] = $buyerInfo->id;
                                          $transaction["buyer_name"] = $buyerInfo->name;
                                          $transaction["discount"] = $this_discount;
                                          $transaction["price_all"] = $this_price;

                                          $transaction["buyer_email"] = $buyerInfo->email;
                                          $transaction["buyer_phone"] = $buyerInfo->mobile_number;
                                          $transaction["buyer_address"] = $buyerInfo->address;
                                          $transaction["buyer_city"] = $buyerInfo->city;
                                          $transaction["buyer_state"] = $buyerInfo->state;
                                          $transaction["buyer_zip"] = $buyerInfo->zip;
                                          if (is_object($sellerInfo)) {
                                              $transaction["seller_id"] = $sellerInfo->id;
                                              $transaction["seller_name"] = $sellerInfo->name;
                                              $transaction["seller_address"] = $sellerInfo->address;
                                              $transaction["seller_email"] = $sellerInfo->email;
                                          }
                                          $transaction["sale_price"] = floatval($record->buy_now_price);
                                          $transaction["datetime"] = date("Y-m-d H:i:s");
                                          if (!FJF_BASE_RICH::insertRecord("transactions", $transaction)) {
                                              $output["status"] = "An error occurred while saving info.";
                                          }
                                      } else {
                                          $record->auction_status = "Canceled";
                                          $record->auction_completion_date = date("Y-m-d H:i:s");
                                          $editor->saveAndPublish();

                                          // SELLER - FAILED COMMISSION PAYMENT
                                          $notificationData["type"] = NotificationModel::TYPE_SELLER_PAYMENT_FAILURE;
                                          $notificationData["uid"] = $sellerInfo->uid;
                                          $notificationData["notification"] = json_encode([
                                              "auction_id" => $record->id,
                                              "make" => $record->make,
                                              "model" => $record->model,
                                              "year" => $record->year,
                                              "status" => "Buy now",
                                              "final_bid" => floatval($record->buy_now_price),
                                              "buyer_fee" => $transaction["buyer_fee"],
                                              "total_price" => (floatval($record->buy_now_price) + $transaction["buyer_fee"]),
                                              "buyer_name" => $buyerInfo->name,
                                              "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                              "time_of_failure" => date("Y-m-d H:i:s")
                                          ]);
                                          $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);

                                          // BUYER - FAILED COMMISSION PAYMENT
                                          $notificationData["type"] = NotificationModel::TYPE_BUYER_PAYMENT_FAILURE;
                                          $notificationData["uid"] = $buyerInfo->uid;
                                          $notificationData["notification"] = json_encode([
                                              "auction_id" => $record->id,
                                              "make" => $record->make,
                                              "model" => $record->model,
                                              "year" => $record->year,
                                              "status" => "Buy now",
                                              "final_bid" => floatval($record->buy_now_price),
                                              "buyer_fee" => $transaction["buyer_fee"],
                                              "total_price" => (floatval($record->buy_now_price) + $transaction["buyer_fee"]),
                                              "buyer_name" => $buyerInfo->name,
                                              "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                              "time_of_failure" => date("Y-m-d H:i:s")
                                          ]);
                                          $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                                          MailModel::sendAdminFailedCommissionEmail($notificationData);
                                      }

                                      if ($output["status"] == "" && $record->auction_status != "Canceled") {
                                          $record->auction_status = "Sold";
                                          $record->auction_completion_date = date("Y-m-d H:i:s");
                                          $editor->saveAndPublish();
                                          $output["redirect"] = "/auctions/" . $auctionID . "/bill/";

                                          // Winning Bid Insertion
                                          $bidFields["user_id"] = $buyerInfo->id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["bid_price"] = $record->buy_now_price;
                                          $bidFields["winning_bid"] = 1;
                                          if (!FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields)) {
                                              $output["status"] = "An error occurred while saving info.";
                                          } else {
                                              // Buyer Wins Auction Notification
                                              $notificationData["type"] = NotificationModel::TYPE_BUYER_BUY_NOW;
                                              $notificationData["uid"] = $buyerInfo->uid;
                                              $notificationData["notification"] = json_encode([
                                                  "auction_id" => $record->id,
                                                  "make" => $record->make,
                                                  "model" => $record->model,
                                                  "year" => $record->year,
                                                  "buy_now_price" => $record->buy_now_price,
                                                  "status" => "Buy now",
                                                  "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                                  "seller_address" => (is_object($sellerInfo)) ? $sellerInfo->address : "",
                                                  "seller_city" => (is_object($sellerInfo)) ? $sellerInfo->city : "",
                                                  "seller_state" => (is_object($sellerInfo)) ? $sellerInfo->state : "",
                                                  "seller_zip" => (is_object($sellerInfo)) ? $sellerInfo->zip : "",
                                                  "seller_email" => (is_object($sellerInfo)) ? $sellerInfo->email : "",
                                                  "seller_phone" => (is_object($sellerInfo)) ? $sellerInfo->mobile_number : ""
                                              ]);
                                              $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                                              // Seller Auction Completes Successfully Notification
                                              if (is_object($sellerInfo)) {
                                                  $notificationData["type"] = NotificationModel::TYPE_SELLER_BUY_NOW;
                                                  $notificationData["uid"] = $sellerInfo->uid;
                                                  $notificationData["notification"] = json_encode([
                                                      "auction_id" => $record->id,
                                                      "make" => $record->make,
                                                      "model" => $record->model,
                                                      "year" => $record->year,
                                                      "status" => "Buy now",
                                                      "buy_now_price" => $record->buy_now_price,
                                                      "buyer_name" => $buyerInfo->name,
                                                      "buyer_address" => $buyerInfo->address,
                                                      "buyer_city" => $buyerInfo->city,
                                                      "buyer_state" => $buyerInfo->state,
                                                      "buyer_zip" => $buyerInfo->zip,
                                                      "buyer_email" => $buyerInfo->email,
                                                      "buyer_phone" => $buyerInfo->mobile_number
                                                  ]);
                                                  $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                                              }
                                          }
                                          unset($bidFields);
                                      }
                                      unset($siteCommission);
                                      unset($transaction);
                                      $code = FJF_BASE_RICH::updateRecord("coupon", ["id" => $code->id, "`limit`" => intval($code->limit) - 1], "id");

                                  } else {
                                      $output["status"] = "Invalid credit card information.";
                                  }
                              }
                          } else {
                              if(!is_object($record)){
                                  $output["status"] = "Action is not exists";
                              }else if($record->id != $auctionID){
                                  $output["status"] = "Action not found";

                              }else if($record->buy_now_price == 0){
                                  $output["status"] = "This auction does not allow immediate purchase";

                              }else if($record->auction_status != "Active" && $record->status != 1){
                                  $output["status"] = "This auction does not allow immediate purchase " .$record->status ;

                              }else if(time() > strtotime($record->expiration_date)){
                                  $output["status"] = "This auction has expired";

                              }else if(!is_object($buyerInfo)){
                                  $output["status"] = "You are not logged in";

                              }else if($buyerInfo->user_type != "Buyer"){
                                  $output["status"] = "You are logged in as a seller so you cannot buy on this product.";

                              }
                          }
                          unset($_SESSION["buy_now_in_progress"]);
                          unset($record);
                          unset($editor);
                      } else {
                          $output["status"] = "The auction code does not exist.";
                      }
                }else
                {
                  $output["status"] = "The discount code does not exist.";
                }

            }
            else{

                  $auctionID = (isset($_POST["auction_id"])) ? intval($_POST["auction_id"]) : 0;
                  $auctionBuyNowInProgress = (isset($_SESSION["buy_now_in_progress"])) ? $_SESSION["buy_now_in_progress"] : 0;
                  $buyerID = SessionModel::loggedUserID();
                  $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $buyerID);

                  if ($buyerInfo->license_expired == 1) {
                      $output["status"] = "Your license is expired. Please renew your license and update your account to continue.";
                  } elseif ($auctionID > 0 ) {
                      $code = '';
                      if($buyerInfo->discount_code != ''){
                          $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $buyerInfo->discount_code,'STATUS' => 1));
                      }


                      $_SESSION["buy_now_in_progress"] = $auctionID;
                      $editorParams = array(
                          "table" => "auctions",
                          "title_field" => "title",
                          "positions" => true,
                          "id" => $auctionID
                      );
                      $editor = new AdminEditRevisionsModel($editorParams);
                      $record = $editor->loadRecord();
                      // print_r($record);die;
                      // $record =  FJF_BASE_RICH::getRecord("auctions", "id = ".$auctionID."  limit 1", array());
                      if (is_object($record) && ($record->id == $auctionID) && $record->buy_now_price > 0 && ($record->auction_status == "Active" || $record->status == 1) && (time() < strtotime($record->expiration_date)) && (is_object($buyerInfo) && $buyerInfo->user_type == "Buyer")) {
                          if (!$buyerInfo->stripe_id) {
                              $output["status"] = "Please add credit card and billing information to your account before placing a bid." . " <a class='update-cc' href='/account/billing-details/'>Update now</a>";
                          } else {

                              $this_price = $record->buy_now_price;
                              $this_discount = 0;

                              if($code && $code != ''){
                                  if($code->type == 1){
                                    $this_discount= (floatval($record->buy_now_price) * intval($code->percent)/100);
                                    $record->buy_now_price = floatval($record->buy_now_price) - (floatval($record->buy_now_price) * intval($code->percent)/100);
                                  }else{
                                    $this_discount= intval($code->price);
                                    $record->buy_now_price = floatval($record->buy_now_price) - intval($code->price);
                                  }
                              }

                              \Stripe\Stripe::setVerifySslCerts(false);
                              StripeModel::setApiKey();
                              $stripeCustomerInfo = StripeModel::getCustomer($buyerInfo->stripe_id);
                              $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $record->user_id);
                              if (is_object($stripeCustomerInfo)) {
                                  // Transaction Insertion
                                  $siteCommission = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_commission' LIMIT 1", null, true, "value");
                                  $buyerFeeCap = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_cap' AND value<>'' LIMIT 1", null, true, "value");
                                  $buyerFee = floatval($siteCommission->value * floatval($record->buy_now_price) / 100);
                                  $uniqueBuyerFee = floatval($buyerInfo->buyer_fee * floatval($record->buy_now_price) / 100);
                                  if (is_object($buyerFeeCap) && floatval($buyerFeeCap->value) > 0 && floatval($buyerFeeCap->value) < $buyerFee) {
                                      $transaction["buyer_fee"] = floatval($buyerFeeCap->value);
                                  } else {
                                      if(isset($buyerInfo->buyer_fee) && $buyerInfo->buyer_fee > 0){
                                          $transaction["buyer_fee"] = $uniqueBuyerFee;
                                      }else{
                                          $transaction["buyer_fee"] = $buyerFee;
                                      }
                                  }



                                  $transaction["stripe_charge_id"] = StripeModel::createCharge($buyerInfo->stripe_id, $transaction["buyer_fee"]);
                                  if ($transaction["stripe_charge_id"] != "") {
                                      $transaction["auction_id"] = $record->id;
                                      $transaction["auction_name"] = ($record->title != "") ? $record->title : $record->year . " " . $record->make . " " . $record->model;
                                      $transaction["buyer_id"] = $buyerInfo->id;
                                      $transaction["buyer_name"] = $buyerInfo->name;
                                      $transaction["buyer_email"] = $buyerInfo->email;
                                      $transaction["buyer_phone"] = $buyerInfo->mobile_number;
                                      $transaction["buyer_address"] = $buyerInfo->address;
                                      $transaction["buyer_city"] = $buyerInfo->city;
                                      $transaction["buyer_state"] = $buyerInfo->state;
                                      $transaction["buyer_zip"] = $buyerInfo->zip;
                                      $transaction["discount"] = $this_discount;
                                      $transaction["price_all"] = $this_price;
                                      if (is_object($sellerInfo)) {
                                          $transaction["seller_id"] = $sellerInfo->id;
                                          $transaction["seller_name"] = $sellerInfo->name;
                                          $transaction["seller_address"] = $sellerInfo->address;
                                          $transaction["seller_email"] = $sellerInfo->email;
                                      }
                                      $transaction["sale_price"] = floatval($record->buy_now_price);
                                      $transaction["datetime"] = date("Y-m-d H:i:s");
                                      if (!FJF_BASE_RICH::insertRecord("transactions", $transaction)) {
                                          $output["status"] = "An error occurred while saving info.";
                                      }
                                  } else {
                                      $record->auction_status = "Canceled";
                                      $record->auction_completion_date = date("Y-m-d H:i:s");
                                      $editor->saveAndPublish();

                                      // SELLER - FAILED COMMISSION PAYMENT
                                      $notificationData["type"] = NotificationModel::TYPE_SELLER_PAYMENT_FAILURE;
                                      $notificationData["uid"] = $sellerInfo->uid;
                                      $notificationData["notification"] = json_encode([
                                          "auction_id" => $record->id,
                                          "make" => $record->make,
                                          "model" => $record->model,
                                          "year" => $record->year,
                                          "status" => "Buy now",
                                          "final_bid" => floatval($record->buy_now_price),
                                          "buyer_fee" => $transaction["buyer_fee"],
                                          "total_price" => (floatval($record->buy_now_price) + $transaction["buyer_fee"]),
                                          "buyer_name" => $buyerInfo->name,
                                          "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                          "time_of_failure" => date("Y-m-d H:i:s")
                                      ]);
                                      $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);

                                      // BUYER - FAILED COMMISSION PAYMENT
                                      $notificationData["type"] = NotificationModel::TYPE_BUYER_PAYMENT_FAILURE;
                                      $notificationData["uid"] = $buyerInfo->uid;
                                      $notificationData["notification"] = json_encode([
                                          "auction_id" => $record->id,
                                          "make" => $record->make,
                                          "model" => $record->model,
                                          "year" => $record->year,
                                          "status" => "Buy now",
                                          "final_bid" => floatval($record->buy_now_price),
                                          "buyer_fee" => $transaction["buyer_fee"],
                                          "total_price" => (floatval($record->buy_now_price) + $transaction["buyer_fee"]),
                                          "buyer_name" => $buyerInfo->name,
                                          "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                          "time_of_failure" => date("Y-m-d H:i:s")
                                      ]);
                                      $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                                      MailModel::sendAdminFailedCommissionEmail($notificationData);
                                  }

                                  if ($output["status"] == "" && $record->auction_status != "Canceled") {
                                      $record->auction_status = "Sold";
                                      $record->auction_completion_date = date("Y-m-d H:i:s");
                                      $editor->saveAndPublish();
                                      $output["redirect"] = "/auctions/" . $auctionID . "/bill/";

                                      // Winning Bid Insertion
                                      $bidFields["user_id"] = $buyerInfo->id;
                                      $bidFields["auction_id"] = $auctionID;
                                      $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                      $bidFields["bid_price"] = $record->buy_now_price;
                                      $bidFields["winning_bid"] = 1;
                                      if (!FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields)) {
                                          $output["status"] = "An error occurred while saving info.";
                                      } else {
                                          // Buyer Wins Auction Notification
                                          $notificationData["type"] = NotificationModel::TYPE_BUYER_BUY_NOW;
                                          $notificationData["uid"] = $buyerInfo->uid;
                                          $notificationData["notification"] = json_encode([
                                              "auction_id" => $record->id,
                                              "make" => $record->make,
                                              "model" => $record->model,
                                              "year" => $record->year,
                                              "buy_now_price" => $record->buy_now_price,
                                              "status" => "Buy now",
                                              "seller_name" => (is_object($sellerInfo)) ? $sellerInfo->name : "",
                                              "seller_address" => (is_object($sellerInfo)) ? $sellerInfo->address : "",
                                              "seller_city" => (is_object($sellerInfo)) ? $sellerInfo->city : "",
                                              "seller_state" => (is_object($sellerInfo)) ? $sellerInfo->state : "",
                                              "seller_zip" => (is_object($sellerInfo)) ? $sellerInfo->zip : "",
                                              "seller_email" => (is_object($sellerInfo)) ? $sellerInfo->email : "",
                                              "seller_phone" => (is_object($sellerInfo)) ? $sellerInfo->mobile_number : ""
                                          ]);
                                          $this->notificationModel->insertNotification($notificationData, $buyerInfo);

                                          // Seller Auction Completes Successfully Notification
                                          if (is_object($sellerInfo)) {
                                              $notificationData["type"] = NotificationModel::TYPE_SELLER_BUY_NOW;
                                              $notificationData["uid"] = $sellerInfo->uid;
                                              $notificationData["notification"] = json_encode([
                                                  "auction_id" => $record->id,
                                                  "make" => $record->make,
                                                  "model" => $record->model,
                                                  "year" => $record->year,
                                                  "status" => "Buy now",
                                                  "buy_now_price" => $record->buy_now_price,
                                                  "buyer_name" => $buyerInfo->name,
                                                  "buyer_address" => $buyerInfo->address,
                                                  "buyer_city" => $buyerInfo->city,
                                                  "buyer_state" => $buyerInfo->state,
                                                  "buyer_zip" => $buyerInfo->zip,
                                                  "buyer_email" => $buyerInfo->email,
                                                  "buyer_phone" => $buyerInfo->mobile_number
                                              ]);
                                              $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                                          }
                                      }
                                      unset($bidFields);
                                  }
                                  unset($siteCommission);
                                  unset($transaction);
                                  if($code && $code != ''){
                                    $code = FJF_BASE_RICH::updateRecord("coupon", ["id" => $code->id, "`limit`" => intval($code->limit) - 1], "id");
                                  }
                              } else {
                                  $output["status"] = "Invalid credit card information.";
                              }
                          }
                      } else {
                          if(!is_object($record)){
                              $output["status"] = "Action is not exists";
                          }else if($record->id != $auctionID){
                              $output["status"] = "Action not found";

                          }else if($record->buy_now_price == 0){
                              $output["status"] = "This auction does not allow immediate purchase";

                          }else if($record->auction_status != "Active" && $record->status != 1){
                              $output["status"] = "This auction does not allow immediate purchase " .$record->status ;

                          }else if(time() > strtotime($record->expiration_date)){
                              $output["status"] = "This auction has expired";

                          }else if(!is_object($buyerInfo)){
                              $output["status"] = "You are not logged in";

                          }else if($buyerInfo->user_type != "Buyer"){
                              $output["status"] = "You are logged in as a seller so you cannot buy on this product.";

                          }
                      }
                      unset($_SESSION["buy_now_in_progress"]);
                      unset($record);
                      unset($editor);
                  } else {
                      $output["status"] = "The auction code does not exist.";
                  }
            }

            // started


            // ends

        }

        $output["has_error"] = ($output["status"] != "") ? true : false;
        header("Content-type: application/json; charset=utf-8");
        print_r(json_encode($output));
        exit;
    }
}

?>

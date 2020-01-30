<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");

class AjaxAuctionsPlaceBid extends FJF_CMD
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
        $output["cc_status"] = "";
        try {
          if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
              $action = (isset($_POST["action"])) ? trim($_POST["action"]) : "";
              $auctionID = (isset($_POST["auction_id"])) ? intval($_POST["auction_id"]) : 0;
              if ($auctionID > 0) {
                  $buyerID = SessionModel::loggedUserID();
                  $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $buyerID);
                  /*$editorParams = array(
                      "table" => "auctions",
                      "title_field" => "title",
                      "positions" => true,
                      "id" => $auctionID
                  );*/
  //                $editor = new AdminEditRevisionsModel($editorParams);
  //                $record = $editor->loadRecord();

                  $recordInfo = ($auctionID > 0) ? RecordsModel::getAllAuctions("a.id = " . $auctionID) : null;
                  $record = (!empty($recordInfo) && is_object($recordInfo[0])) ? $recordInfo[0] : null;

                  if (is_object($record) && ($record->id == $auctionID) && (is_object($buyerInfo) && $buyerInfo->user_type == "Buyer") && $record->auction_status == "Active" && (time() < strtotime($record->expiration_date))) {
                      if (!$buyerInfo->stripe_id) {
                          $output["cc_status"] = "Please add credit card and billing information to your account before placing a bid." . " <a class='update-cc' href='/account/billing-details/'>Update now</a>";
                      } else {
                          \Stripe\Stripe::setVerifySslCerts(false);
                          StripeModel::setApiKey();
                          $stripeCustomerInfo = StripeModel::getCustomer($buyerInfo->stripe_id);
                          $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $record->user_id);
                          if (is_object($stripeCustomerInfo)) {
                              $bidPrice = 0;
                              $currentBidPrice = RecordsModel::getAuctionMaxBidPrice($auctionID);
                              $startingBidPrice = floatval($record->starting_bid_price);
                              if ($action == "place-bid") {
                                  $bidPrice = (isset($_POST["bid_price"])) ? FJF_BASE::moneyUnformat($_POST["bid_price"]) : 0;
                              } elseif ($action == "mobile-place-bid") {
                                  $bidPrice = (isset($_POST["mobile_bid_price"])) ? FJF_BASE::moneyUnformat($_POST["mobile_bid_price"]) : 0;
                              } elseif ($action == "mobile-popup-place-bid") {
                                  $bidPrice = (isset($_POST["mobile_popup_bid_price"])) ? FJF_BASE::moneyUnformat($_POST["mobile_popup_bid_price"]) : 0;
                              } elseif ($action == "popup-place-bid") {
                                  $bidPrice = (isset($_POST["popup_bid_price"])) ? FJF_BASE::moneyUnformat($_POST["popup_bid_price"]) : 0;
                              } elseif ($action == "place-quick-bid") {
                                  $bidPrice = (isset($_POST["quick_bid"])) ? FJF_BASE::moneyUnformat($_POST["quick_bid"]) : 0;
                              } elseif ($action == "mobile-place-quick-bid") {
                                  $bidPrice = (isset($_POST["mobile_quick_bid"])) ? FJF_BASE::moneyUnformat($_POST["mobile_quick_bid"]) : 0;
                              }

                              //  Custom code
                              $winning = RecordsModel::getWinning($auctionID);

                              if ($buyerInfo->license_expired == 1) {
                                  $output["status"] = "Your license is expired. Please renew your license and update your account to continue.";
                              } elseif ($buyerInfo->cc_expired == 1) {
                                  $output["status"] = "Your credit card is expired. Please update your payment information in your account to continue." . " <a class='update-cc' href='/account/billing-details/'>Update now</a>";
                              } elseif ($bidPrice === "") {
                                  $output["status"] = "Amount is missing.";
                              } elseif (!is_numeric($bidPrice)) {
                                  $output["status"] = "Enter valid amount.";
                              } elseif ($currentBidPrice == 0) {
                                  if ($bidPrice <= $startingBidPrice) {
                                      $output["status"] = "Amount should be greater than $" . FJF_BASE::moneyFormat($startingBidPrice);
                                  }elseif ($bidPrice < FJF_BASE::moneyFormat(($startingBidPrice + 50))) {
                                      $output["status"] = "The current minimum bid is $" . FJF_BASE::moneyFormat(($startingBidPrice + 50));
                                  }
                              } elseif ($currentBidPrice > 0 && $bidPrice != "") {
                                  if ($bidPrice <= $currentBidPrice) {
  //                                    $output["status"] = "Amount should be greater than $" . FJF_BASE::moneyFormat($currentBidPrice + 50);
                                  } elseif ($bidPrice < ($currentBidPrice + 50)) {
                                      $output["status"] = "The current minimum bid is $" . FJF_BASE::moneyFormat(($currentBidPrice + 50));
                                  }
                              } elseif ((int) $bidPrice < (int) $currentBidPrice + 50) {
                                  $output["status"] = "The amount must be greater than or equal to $" . FJF_BASE::moneyFormat((int) $currentBidPrice + 50);
                              } elseif ((int) $bidPrice < (int) $winning->bid_price + 50) {
                                  $output["status"] = "The amount must be greater than or equal to $" . FJF_BASE::moneyFormat((int) $winning->bid_price + 50);
                              } elseif ((int)$bidPrice % 50 != 0) {
                                  $output["status"] = "The amount must be a multiple of $50";
                              }
                              if ($output["status"] == "") {
                                  if((int) $bidPrice < (int) $currentBidPrice + 50){
                                        $output["status"] = "The amount must be greater than or equal to $" . FJF_BASE::moneyFormat((int) $currentBidPrice + 50);
                                  }
                                  if ($output["status"] == "") {
                                  /**
                                   * PROXY BID
                                   * If reserve price more than custom bid then will not use custom price
                                   * So we will use current price add more 50$ to insert data
                                   */
  //                                $__bid_price = @$_POST["bid_price"];
  //                                if(!empty($__bid_price) && $__bid_price > 0) {
  //                                    if($record->reserve_price > $__bid_price && $__bid_price > $currentBidPrice && $currentBidPrice > 0 ) {
  //                                        $bidPrice = FJF_BASE::moneyUnformat($currentBidPrice + 50);
  //                                    } else if($record->reserve_price > $__bid_price && $currentBidPrice == 0) {
  //                                        $bidPrice = FJF_BASE::moneyUnformat(($startingBidPrice + 50));
  //                                    } else if ($record->reserve_price < $__bid_price && $__bid_price < $currentBidPrice ) {
  //                                        var_dump($record->reserve_price, $__bid_price, $currentBidPrice);
  //                                        $bidPrice = FJF_BASE::moneyUnformat(($startingBidPrice + 50));
  //                                    }
  //                                }
                                  $bidPrice = (int) $bidPrice;

                                  if (!is_object($winning)) {
                                      $bidFields["user_id"] = $buyerInfo->id;
                                      $bidFields["auction_id"] = $auctionID;
                                      $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                      $bidFields["bid_price"] = (int)$record->reserve_price <= $bidPrice ? (int)$record->reserve_price : (int) $record->starting_bid_price + 50;
                                      $bidFields["maximum_proxy"] = $bidPrice;
                                      $bidFields["winning_bid"] = 1;

                                      RecordsModel::resetWinningAuctionsBids($auctionID);
                                      FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                      RecordsModel::updateWinner($auctionID, $buyerInfo->id);
                                      unset($bidFields);
                                  } else {
                                      if ($buyerInfo->id == $winning->user_id) {
                                          $bidFields["user_id"] = $buyerInfo->id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["maximum_proxy"] = $bidPrice;
                                          if ((int)$record->reserve_price <= $bidPrice && $winning->bid_price < (int)$record->reserve_price) {
                                              $bid_price = (int)$record->reserve_price;
                                          } else {
                                              $bid_price = $winning->bid_price;
                                          }
                                          $bidFields["bid_price"] = $bid_price;
                                          $bidFields["winning_bid"] = 1;

                                          RecordsModel::resetWinningAuctionsBids($auctionID);
                                          $firstBuyerMaximum = RecordsModel::getFirstBuyerMaximum($auctionID);
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          unset($bidFields);

                                          RecordsModel::deleteRecord('auctions_bids', $firstBuyerMaximum->id);
                                      } elseif ($bidPrice < $winning->maximum_proxy) {
                                          $bidFields["user_id"] = $buyerInfo->id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["bid_price"] = $bidPrice;
                                          $bidFields["maximum_proxy"] = $bidPrice;
                                          $bidFields["winning_bid"] = 0;
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          unset($bidFields);

                                          //  Auto create bid for winning
                                          $bidFields["user_id"] = $winning->user_id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["bid_price"] = $bidPrice + 50;
                                          $bidFields["maximum_proxy"] = $winning->maximum_proxy;
                                          $bidFields["winning_bid"] = 1;

                                          RecordsModel::resetWinningAuctionsBids($auctionID);
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          unset($bidFields);
                                      } else if ($bidPrice == $winning->maximum_proxy) {
                                          $bidFields["user_id"] = $buyerInfo->id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["bid_price"] = $bidPrice;
                                          $bidFields["maximum_proxy"] = $bidPrice;
                                          $bidFields["winning_bid"] = 0;
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          unset($bidFields);

                                          //  Auto create bid for winning
                                          $bidFields["user_id"] = $winning->user_id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          $bidFields["bid_price"] = $bidPrice;
                                          $bidFields["maximum_proxy"] = $winning->maximum_proxy;
                                          $bidFields["winning_bid"] = 1;

                                          RecordsModel::resetWinningAuctionsBids($auctionID);
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          unset($bidFields);
                                      } else {
                                          $bidFields["user_id"] = $buyerInfo->id;
                                          $bidFields["auction_id"] = $auctionID;
                                          $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                          if ((int)$record->reserve_price <= $bidPrice && $winning->bid_price < (int)$record->reserve_price) {
                                              $bid_price = (int)$record->reserve_price;
                                          } else {
                                              $bid_price = (int) $winning->maximum_proxy + 50;
                                          }
                                          $bidFields["bid_price"] = $bid_price;
                                          $bidFields["maximum_proxy"] = $bidPrice;
                                          $bidFields["winning_bid"] = 1;

                                          RecordsModel::resetWinningAuctionsBids($auctionID);
                                          FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);
                                          RecordsModel::updateWinner($auctionID, $buyerInfo->id);
                                          unset($bidFields);
                                      }
                                  }

                                  /*$bidFields["user_id"] = $buyerInfo->id;
                                  $bidFields["auction_id"] = $auctionID;
                                  $bidFields["datetime_create"] = date("Y-m-d H:i:s");
                                  $bidFields["bid_price"] = $bidPrice;
                                  FJF_BASE_RICH::saveRecord("auctions_bids", $bidFields);*/
                                  if($record->reserve_price > 0 && $bidPrice >= $record->reserve_price){
                                      $reservePrise = "Reserve Met.";
                                  }elseif($record->reserve_price > 0 && $bidPrice < $record->reserve_price){
                                      $reservePrise = "Reserve Not Met.";
                                  }else{
                                      $reservePrise = "";
                                  }
                                  $output["message_info"] = "You bid $" . FJF_BASE::moneyFormat($bidPrice) . " on " . $record->year . " " . $record->make . " " . $record->model . ". " . $reservePrise;
                                  // if a bid is entered within the last 59 seconds of an auction, the deadline should automatically be extended by another 60 seconds
                                  $timeExpirationDate = strtotime($record->expiration_date);
                                  if (time() > ($timeExpirationDate - 59)) {
                                      $record->expiration_date = date("Y-m-d H:i:s", time() + 60);
                                      $editor->saveAndPublish();
                                  }

                                  // if buyer bids on an auction, automatically add to "Watched Listings"
                                  $favoriteInfo = FJF_BASE_RICH::getRecord("users_favorites", "record_id = 'RECORD_ID' AND user_id = 'USER_ID'", array("RECORD_ID" => $auctionID, "USER_ID" => $buyerInfo->id));
                                  if ($favoriteInfo == null) {
                                      $watchedListingsFields["user_id"] = $buyerInfo->id;
                                      $watchedListingsFields["record_id"] = $auctionID;
                                      $watchedListingsFields["date"] = date("Y-m-d H:i:s");
                                      FJF_BASE_RICH::insertRecord("users_favorites", $watchedListingsFields, "id");
                                      unset($watchedListingsFields);
                                      unset($favoriteInfo);
                                  }

                                  // Seller Bid Placed Notification
                                  if (is_object($sellerInfo)) {
                                      $notificationData["type"] = NotificationModel::TYPE_SELLER_BID_PLACED;
                                      $notificationData["uid"] = $sellerInfo->uid;

                                      $auction_win_big = FJF_BASE_RICH::getRecord("auctions_bids", "auction_id = ".$auctionID."  ORDER BY `bid_price` DESC limit 1", array());
                                      $notificationData["notification"] = json_encode([
                                          "auction_id" => $auctionID,
                                          "buyer_name" => $buyerInfo->name,
                                          "amount" => $bidPrice,
                                          "status" => "New Bid",
                                          "current_bid" => $auction_win_big->bid_price,
                                          "make" => $record->make,
                                          "model" => $record->model,
                                          "year" => $record->year
                                      ]);
                                      $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                                      unset($notificationData);
                                  }

                                  // Buyer Bid Placed Notification
                                  $notificationData["type"] = NotificationModel::TYPE_BUYER_BID_PLACED;
                                  $notificationData["uid"] = $buyerInfo->uid;
                                  $notificationData["notification"] = json_encode([
                                      "auction_id" => $auctionID,
                                      "amount" => $bidPrice,
                                      "status" => "You Bid",
                                      "current_bid" => $bidPrice,
                                      "make" => $record->make,
                                      "model" => $record->model,
                                      "year" => $record->year
                                  ]);
                                  $this->notificationModel->insertNotification($notificationData, $buyerInfo);
                                  unset($notificationData);

                                  // Buyer Outbid Auction Notification
                                  $auctionCurrentBidInfo = FJF_BASE_RICH::getRecord("auctions_bids", "bid_price = 'CURRENT_BID' AND auction_id = 'AUCTION_ID'", array("CURRENT_BID" => $currentBidPrice, "AUCTION_ID" => $auctionID));
                                  if (!empty($auctionCurrentBidInfo)) {
                                      $previousBidUserInfo = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array("USER_ID" => $auctionCurrentBidInfo->user_id));
                                      if (is_object($previousBidUserInfo) && $previousBidUserInfo->id != $buyerInfo->id) {
                                          $notificationData["type"] = NotificationModel::TYPE_BUYER_OUTBID_AUCTION;
                                          $notificationData["uid"] = $previousBidUserInfo->uid;
                                          $notificationData["notification"] = json_encode([
                                              "auction_id" => $auctionID,
                                              "amount" => $bidPrice,
                                              "status" => "You've Been Outbid",
                                              "current_bid" => $bidPrice,
                                              "previous_bid" => $currentBidPrice,
                                              "make" => $record->make,
                                              "model" => $record->model,
                                              "year" => $record->year
                                          ]);
                                          $this->notificationModel->insertNotification($notificationData, $previousBidUserInfo);
                                          unset($notificationData);
                                      }
                                      unset($auctionCurrentBidInfo);
                                  }
                                  unset($bidFields);
                                }
                              }
                          } else {
                              $output["cc_status"] = "Invalid credit card information.";
                          }
                      }
                  } else {
                      $output["status"] = "You are logged in as a seller so you cannot bid on this product.";
                  }
                  unset($record);
                  unset($editor);
              } else {
                  $output["status"] = "The auction code does not exist.";
              }
          }
        } catch (Exception $e) {
            $output["status"] = "The mailing system is experiencing an error. Please contact the administrator";
        }


        $output["has_error"] = ($output["status"] != "" || $output["cc_status"] != "") ? true : false;
        header("Content-type: application/json; charset=utf-8");
        print_r(json_encode($output));
        exit;
    }
}

?>

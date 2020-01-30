<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class CronExpiringAuctions extends FJF_CMD
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
        $timeNow = time();
        $auctions = FJF_BASE_RICH::getRecords("auctions", "status = 1 AND approved = 1 AND auction_status = 'Active' AND expiration_date > NOW()", [], false, "id, user_id, title, make, model, year, expiration_date");
        if (!empty($auctions)) {
            foreach ($auctions as $auction) {
                $auctionExpirationDate = isset($auction->expiration_date) && $auction->expiration_date != "" ? strtotime($auction->expiration_date) : 0;
                if ($auctionExpirationDate > 0) {
                    $maxBidObj = FJF_BASE_RICH::getRecords("auctions_bids", "bid_price=(SELECT MAX(bid_price) FROM auctions_bids WHERE auction_id = " . $auction->id . ")", [], true, "id, user_id, bid_price");
                    $currentBid = (is_object($maxBidObj)) ? $maxBidObj->bid_price : 0;
                    $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $auction->user_id);
                    $usersWatchedCurrentAuction = FJF_BASE_RICH::getRecords("users_favorites", "record_id = " . $auction->id, [], false, "id, user_id, record_id");
                    $watchedAuctionsUsersIDs = array();
                    if (!empty($usersWatchedCurrentAuction)) {
                        foreach ($usersWatchedCurrentAuction as $userWatchedAuction) {
                            $watchedAuctionsUsersIDs[] = $userWatchedAuction->user_id;
                        }
                        $usersWhoWatchedAuction = FJF_BASE_RICH::getRecords("users", "id IN (" . implode(", ", $watchedAuctionsUsersIDs) . ")", [], false);
                        if (!empty($usersWhoWatchedAuction)) {
                            foreach ($usersWhoWatchedAuction as $user) {
                                // WATCHED LISTING IS EXPIRING IN 24 HOURS: MAKE MODEL - YEAR ENDS SOON (VIEW BUTTON LINK TO AUCTION)
                                if ($timeNow > ($auctionExpirationDate - 86760) && $timeNow < ($auctionExpirationDate - 86400)) {
                                    $notificationData["type"] = NotificationModel::TYPE_BUYER_LISTING_EXPIRING_24HOURS;
                                    $notificationData["uid"] = $user->uid;
                                    $notificationData["notification"] = json_encode([
                                        "auction_id" => $auction->id,
                                        "buyer_id" => $user->id,
                                        "make" => $auction->make,
                                        "model" => $auction->model,
                                        "year" => $auction->year,
                                        "current_bid" => floatval($currentBid)
                                    ]);
                                    $this->notificationModel->insertNotification($notificationData, $user);
                                }

                                // BUYER WATCHED LISTING EXPIRING IN 1 HOUR: MAKE MODEL - YEAR ENDS IN 1 HOUR
                                if ($timeNow > ($auctionExpirationDate - 3960) && $timeNow < ($auctionExpirationDate - 3600)) {
                                    $notificationData["type"] = NotificationModel::TYPE_BUYER_LISTING_EXPIRING_1HOUR;
                                    $notificationData["uid"] = $user->uid;
                                    $notificationData["notification"] = json_encode([
                                        "auction_id" => $auction->id,
                                        "buyer_id" => $user->id,
                                        "make" => $auction->make,
                                        "model" => $auction->model,
                                        "year" => $auction->year,
                                        "current_bid" => floatval($currentBid)
                                    ]);
                                    $this->notificationModel->insertNotification($notificationData, $user);
                                }

                                // BUYER LISTING EXPIRING 5 MINUTES
                                if ($timeNow > ($auctionExpirationDate - 660) && $timeNow < ($auctionExpirationDate - 300)) {
                                    $notificationData["type"] = NotificationModel::TYPE_BUYER_LISTING_EXPIRING_5MINUTES;
                                    $notificationData["uid"] = $user->uid;
                                    $notificationData["notification"] = json_encode([
                                        "auction_id" => $auction->id,
                                        "buyer_id" => $user->id,
                                        "make" => $auction->make,
                                        "model" => $auction->model,
                                        "year" => $auction->year,
                                        "current_bid" => floatval($currentBid)
                                    ]);
                                    $this->notificationModel->insertNotification($notificationData, $user);
                                }
                            }
                        }
                    }

                    // SELLER LISTING IS EXPIRING IN 24 HOURS: MAKE MODEL - YEAR ENDS SOON
                    if ($timeNow > ($auctionExpirationDate - 86760) && $timeNow < ($auctionExpirationDate - 86400)) {
                        $notificationData["type"] = NotificationModel::TYPE_SELLER_LISTING_EXPIRING_24HOURS;
                        $notificationData["uid"] = $sellerInfo->uid;
                        $notificationData["notification"] = json_encode([
                            "auction_id" => $auction->id,
                            "seller_id" => $sellerInfo->id,
                            "make" => $auction->make,
                            "model" => $auction->model,
                            "year" => $auction->year,
                            "current_bid" => floatval($currentBid)
                        ]);
                        $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                    }

                    // SELLER LISTING IS EXPIRING IN 1 HOUR: MAKE MODEL - YEAR ENDS IN 1 HOUR
                    if ($timeNow > ($auctionExpirationDate - 3960) && $timeNow < ($auctionExpirationDate - 3600)) {
                        $notificationData["type"] = NotificationModel::TYPE_SELLER_LISTING_EXPIRING_1HOUR;
                        $notificationData["uid"] = $sellerInfo->uid;
                        $notificationData["notification"] = json_encode([
                            "auction_id" => $auction->id,
                            "seller_id" => $sellerInfo->id,
                            "make" => $auction->make,
                            "model" => $auction->model,
                            "year" => $auction->year,
                            "current_bid" => floatval($currentBid)
                        ]);
                        $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                    }

                    // SELLER LISTING EXPIRING 5 MINUTES
                    if ($timeNow > ($auctionExpirationDate - 660) && $timeNow < ($auctionExpirationDate - 300)) {
                        $notificationData["type"] = NotificationModel::TYPE_SELLER_LISTING_EXPIRING_5MINUTES;
                        $notificationData["uid"] = $sellerInfo->uid;
                        $notificationData["notification"] = json_encode([
                            "auction_id" => $auction->id,
                            "seller_id" => $sellerInfo->id,
                            "make" => $auction->make,
                            "model" => $auction->model,
                            "year" => $auction->year,
                            "current_bid" => floatval($currentBid)
                        ]);
                        $this->notificationModel->insertNotification($notificationData, $sellerInfo , 1);
                    }
                }
            }
        }
        exit("Done.");
    }
}

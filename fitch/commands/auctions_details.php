<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class AuctionsDetails extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;
    var $notificationModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        $this->notificationModel = new NotificationModel();
    }

    function execute()
    {

        $this->accept_high_bid();
        $auctionID = (isset($_REQUEST["id"])) ? intval($_REQUEST["id"]) : 0;

        $isLoggedIn = SessionModel::isUser();
        $userID = ($isLoggedIn) ? SessionModel::loggedUserID() : 0;
        $userInfo = ($userID > 0) ? FJF_BASE_RICH::getRecordBy("users", $userID) : null;

        $recordInfo = ($auctionID > 0) ? RecordsModel::getAllAuctions("a.id = " . $auctionID) : null;
        $auctionInfo = (!empty($recordInfo) && is_object($recordInfo[0])) ? $recordInfo[0] : null;
        if(!$isLoggedIn && is_object($auctionInfo) && isset($auctionInfo->id)){
            FJF_BASE::redirect("/login/?redirect=/auctions/" . $auctionInfo->id . "/");
        }

        /*if ($userInfo->user_type == 'Seller' && $auctionInfo->user_id != $userInfo->id) {
            FJF_BASE::redirect("/auctions/");
        }*/

        if (empty($auctionInfo) || !$isLoggedIn && $auctionInfo->auction_status == "Refunded" || $isLoggedIn && $auctionInfo->user_id != $userID && $auctionInfo->auction_status == "Refunded") {
            FJF_BASE::redirect("/auctions/");
        }

        RecordsModel::autoUpdateCountViewAuction($auctionID, (int)$auctionInfo->count_view + 1);

        //  Get winning
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auctionInfo->id . " AND winning_bid = 1 ORDER BY id DESC";
        $winning = FJF_BASE_RICH::selectRecords($sql, null, true);
        $auctionInfo->winning_user_id = @$winning->user_id;

        $auctionInfo->you_are_winner = $auctionInfo->winning_user_id == $userInfo->id ? true : false;

        $dealersOnly = ($auctionInfo->sell_to == 1) ? "Yes" : "No";
        if (!empty($userInfo) && $auctionInfo->sell_to == 1) {
            if ($userInfo->user_type == "Buyer") {
                $dealersOnly = "No";
            } elseif ($userInfo->user_type == "Seller" && $auctionInfo->user_id === $userInfo->id) {
                $dealersOnly = "No";
            }
        }

        $defaultTermsConditions = FJF_BASE_RICH::getRecord("site_vars", "name = 'default_terms_conditions'");
        $defaultAdditionalFees = FJF_BASE_RICH::getRecord("site_vars", "name = 'default_additional_fees'");

        $auctionInfo->buy_now_price_main = $auctionInfo->buy_now_price;
        $auctionInfo->starting_bid_price_edit = $auctionInfo->starting_bid_price;

        $auctionInfo->auction_length = round((strtotime($auctionInfo->expiration_date) - time()) / (60 * 60 * 24));

        $sellerInfo = FJF_BASE_RICH::getRecordBy("users", $auctionInfo->user_id);

        $userWatched = array();
        if ($recordInfo && $userInfo) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "record_id";
            $userWatched = FJF_BASE_RICH::getRecords("users_favorites", "user_id=" . $userInfo->id);
            $userWatched = $userWatched ? array_keys($userWatched) : array();
        }

        if (is_object($sellerInfo) && $sellerInfo->lat != "" && $sellerInfo->lon != "") {
            if (is_object($userInfo)) {
                if (!$userInfo->lat && !$userInfo->lon) {
                    $latLon = RecordsModel::getLatLon($userInfo->zip);
                    $userInfo->lat = $latLon["lat"];
                    $userInfo->lon = $latLon["lon"];
                }
                $sellerInfo->distance = ($userInfo->lat != "" && $userInfo->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($userInfo->lat, $userInfo->lon, $sellerInfo->lat, $sellerInfo->lon, 3959) : "";
            } else {
                $latLon = RecordsModel::getLatLonByIP();
                $sellerInfo->distance = ($latLon["lat"] != "" && $latLon["lon"] != "") ? RecordsModel::getDistanceFromBuyerToSeller($latLon["lat"], $latLon["lon"], $sellerInfo->lat, $sellerInfo->lon, 3959) : "";
            }
        }

        $auctionBids = array();
        if (is_object($userInfo) && $userInfo->user_type == "Seller") {
            $auctionBids = FJF_BASE_RICH::getRecords("auctions_bids", "auction_id=" . $auctionInfo->id . " ORDER BY datetime_create DESC");
            if (!empty($auctionBids)) {
                foreach ($auctionBids as $bid) {
                    $buyerInfo = FJF_BASE_RICH::getRecordBy("users", $bid->user_id);
                    $bid->buyer_name = $buyerInfo->name;
                    $bid->location = ($buyerInfo->city != "" && $buyerInfo->state != "") ? $buyerInfo->city . ", " . $buyerInfo->state : "";
                }
            }
        }
        /**
         * List bids for buyer
         */
        $auctionBids_for_buyer = FJF_BASE_RICH::getRecords("auctions_bids", "auction_id=" . $auctionID . " ORDER BY datetime_create DESC");

        if ($auctionInfo->terms_conditions == "") {
            if ($auctionInfo->terms_condition_id != 0) {
                $termsConditions = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id='TERM_ID'", array("TERM_ID" => $auctionInfo->terms_condition_id));
                $auctionInfo->terms_conditions = ($termsConditions && is_object($termsConditions)) ? $termsConditions->description : "";
            } elseif ($auctionInfo->additional_fees_id == 0) {
                $auctionInfo->terms_conditions = $defaultTermsConditions->value;
            }
        }
        if ($auctionInfo->additional_fees == "") {
            if ($auctionInfo->additional_fees_id != 0) {
                $termsConditions = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id='ADDITIONAL_ID'", array("ADDITIONAL_ID" => $auctionInfo->additional_fees_id));
                $auctionInfo->additional_fees = ($termsConditions && is_object($termsConditions)) ? $termsConditions->description : "";
            } elseif ($auctionInfo->additional_fees_id == 0) {
                $auctionInfo->additional_fees = $defaultAdditionalFees->value;
            }
        }

        $auctionInfo->user_max_bid_on_auction = "";
        if (is_object($userInfo)) {
            $userBidsOnAuction = FJF_BASE_RICH::getRecords("auctions_bids", "user_id=" . $userInfo->id . " AND auction_id=" . $auctionInfo->id . " ORDER BY datetime_create DESC");
            if (!empty($userBidsOnAuction)) {
                $userBidsOnAuctionArr = array();
                foreach ($userBidsOnAuction as $userBidOnAuction) {
                    $userBidsOnAuctionArr[] = $userBidOnAuction->bid_price;
                }
                $auctionInfo->user_max_bid_on_auction = max($userBidsOnAuctionArr);
            }
        }

        $auctionInfo->user_maximum_proxy_bid_on_auction = "";
        if (is_object($userInfo)) {
            $userBidsOnAuction = FJF_BASE_RICH::getRecords("auctions_bids", "user_id=" . $userInfo->id . " AND auction_id=" . $auctionInfo->id . " ORDER BY datetime_create DESC");
            if (!empty($userBidsOnAuction)) {
                $userBidsOnAuctionArr = array();
                foreach ($userBidsOnAuction as $userBidOnAuction) {
                    $userBidsOnAuctionArr[] = $userBidOnAuction->maximum_proxy;
                }
                $auctionInfo->user_maximum_proxy_bid_on_auction = max($userBidsOnAuctionArr);
            }
        }

        $auctionInfo->meta_title = $auctionInfo->year . " " . $auctionInfo->make . " " . $auctionInfo->model;
        $auctionInfo->meta_keywords = "";
        $auctionInfo->meta_description = $auctionInfo->description;

        // BUYER FEE
        $buyerFeeObj = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_commission' AND value<>'' LIMIT 1", null, true, "value");
        $buyerFeeCap = FJF_BASE_RICH::getRecords("site_vars", "name='buyer_fee_cap' AND value<>'' LIMIT 1", null, true, "value");
        $buyerFee = floatval($buyerFeeObj->value * $auctionInfo->current_bid_price / 100);
        if (is_object($buyerFeeCap) && floatval($buyerFeeCap->value) > 0 && floatval($buyerFeeCap->value) < $buyerFee) {
            $auctionInfo->buyer_fee = " $" . floatval($buyerFeeCap->value);
        } else {
            if(is_object($userInfo) && isset($userInfo->buyer_fee) && $userInfo->buyer_fee > 0){
                $auctionInfo->buyer_fee = $userInfo->buyer_fee . "% of Winning Bid";
            }else{
                $auctionInfo->buyer_fee = $buyerFeeObj->value . "% of Winning Bid";
            }
        }

        $this->pageModel->extractMetadata($auctionInfo);

        if (isset($auctionInfo->current_bid_price) && $auctionInfo->current_bid_price != "") {
            $auctionCurrentBidInfo = FJF_BASE_RICH::getRecord("auctions_bids", "bid_price = 'CURRENT_BID_PRICE' AND auction_id = 'AUCTION_ID'", array("CURRENT_BID_PRICE" => $auctionInfo->current_bid_price, "AUCTION_ID" => $auctionID));
            if ($auctionCurrentBidInfo->user_id == $userID) {
                $auctionInfo->buyer_last_bid_is_current_bid = "Yes";
            } else {
                $auctionInfo->buyer_last_bid_is_current_bid = "No";
            }
        } else {
            $auctionInfo->buyer_last_bid_is_current_bid = "No";
        }

        $auctionInfo->winning_user_name = "";
        if ($auctionInfo->winning_user_id != "" || $auctionInfo->winning_user_id != 0) {
            $winningUserInfo = FJF_BASE_RICH::getRecord("users", "id='USER_ID'", array("USER_ID" => $auctionInfo->winning_user_id));
            if (is_object($winningUserInfo)) {
                $auctionInfo->winning_user_name = $winningUserInfo->name;
            }
        }

        $auctionInfo->winning_buyer_fee = "";
        if ($auctionInfo->winning_user_id != "") {
            $winningUserInfo = FJF_BASE_RICH::getRecord("transactions", "auction_id='AUC_ID' AND buyer_id='BUYER_ID'", array("BUYER_ID" => $auctionInfo->winning_user_id, "AUC_ID" => $auctionInfo->id));
            if (is_object($winningUserInfo) && $winningUserInfo->buyer_fee) {
                $auctionInfo->winning_buyer_fee = $winningUserInfo->buyer_fee;
            }
        }

        $auctionInfo->count_saved = 0;
        $buyerThatHaveFavoritedThisAuction = FJF_BASE_RICH::getRecords("users_favorites", "record_id=" . $auctionInfo->id);
        if (!empty($buyerThatHaveFavoritedThisAuction)) {
            $auctionInfo->count_saved = count($buyerThatHaveFavoritedThisAuction);
        }

        $auctionInfo->refunded_date = "";
        $refundedInfo = FJF_BASE_RICH::getRecord("transactions", "status='Refunded' AND auction_id='AUC_ID'", array("AUC_ID" => $auctionInfo->id));
        if (is_object($refundedInfo)) {
            $auctionInfo->refunded_date = $refundedInfo->datetime;
        }

        $swipeboxItems = [];
        if (!empty($auctionInfo->photos)) {
            foreach ($auctionInfo->photos as $auctionPhotoKey => $auctionPhoto) {
                $swipeboxItems[$auctionPhotoKey]["href"] = "/site_media/" . $auctionPhoto->photo . "/_orig/";
            }
        }

        // setting fake Completed (when cron hadn't updated yet)
        $auctionInfo->auction_fake_winning_bid = "";
        if ($auctionInfo->auction_status == "Active" && time() > strtotime($auctionInfo->expiration_date)) {
            $auctionInfo->auction_fake_winning_bid = "N/A";
            $auctionInfo->auction_status = "Sold";
        }
//        var_dump($auctionInfo); die;


        $flag_discount = 2;
        if($userInfo->discount_code != ''){

          $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $userInfo->discount_code,'STATUS' => 1));
          if($code){
              $flag_discount = 1;
          }else{
              $flag_discount = 2;
          }
        }else{
          $flag_discount = 2;
        }

        if($flag_discount == 1){
          if($code->type == 1){
                $auctionInfo->this_price = $auctionInfo->buy_now_price;
                $auctionInfo->buy_now_price = floatval($auctionInfo->buy_now_price) - (floatval($auctionInfo->buy_now_price) * intval($code->percent)/100);
          }else{
                $auctionInfo->this_price = $auctionInfo->buy_now_price;
                $auctionInfo->buy_now_price = floatval($auctionInfo->buy_now_price) - intval($code->price);
          }


        }


        $templateParams = array(
            "flag_discount" => $flag_discount,
            "auction_info" => $auctionInfo,
            "seller_info" => $sellerInfo,
            "user_watched" => $userWatched,
            "user" => $userInfo,
            "auctions_bids" => $auctionBids,
            "is_logged" => $userID,
            "dealers_only" => $dealersOnly,
            "swipebox_items" => json_encode($swipeboxItems),
            "button_unsold" => false,
            "is_seller" => false,
            "timestamp" => date('M d, Y | H:i:s',time()) . " CEST",
            "buy_now_off" => false
        );
        /**
         * Off buy now if full reserve price
         * Off button unsold
         */
        if( !empty($auctionBids_for_buyer) && count($auctionBids_for_buyer) > 0) {
            if($auctionBids_for_buyer[0]->bid_price >= $auctionInfo->reserve_price) {
                $templateParams['buy_now_off'] = true;
                // if(SessionModel::loggedUserID() === $auctionInfo->user_id && ) {
                //     $now = strtotime(date('Y-m-d H:i:s',time()));
                //     $expire_time = strtotime($auctionBids[0]->datetime_create);
                //     $hours = ($now - $expire_time) / 3600;
                //     if($hours <= 24 ) {
                //         $templateParams['button_unsold'] = true;
                //     }
                // }
            }
        }
        /**
         * Check winning bid
         */
        //$has_complete = FJF_BASE_RICH::getRecords("auctions_bids", "auction_id='" . $auctionInfo->id . "' and winning_bid=1 ",null,false,"count(*) as count");
        /**
         * @time July 15 , 2019
         * The system will provide a notification,
         * and a button under the sellers “unsold” listings to accept the high bid which is good for 24 hours of the auction close
         */
        if(SessionModel::loggedUserID() === $auctionInfo->user_id && !empty($auctionBids[0])) {
            //if($auctionInfo->expiration_date) {
                $now = strtotime(date('Y-m-d H:i:s',time()));
                $expire_time = strtotime($auctionBids[0]->datetime_create);
                $hours = ($now - $expire_time) / 3600;
                if($hours <= 24 ) {
                    $templateParams['button_unsold'] = true;
                }
            //}
            /**
             * Add more option check seller or buyer for realtime function
             */
            $templateParams['is_seller'] = true;
        }

        //  Get Uship
        /*$sql = "SELECT year, make, model, created_by";
        $sql .= " FROM auctions";
        $sql .= " WHERE id = " . $auctionID;
        $auction = FJF_BASE_RICH::selectRecords($sql, null, true);
        $saller = FJF_BASE_RICH::getRecordBy("users", $auction->created_by);
        $uship = $this->getUship($saller, $userInfo, $auction);

        $templateParams['uship'] = [
            'from' => @$uship->route->items[0]->address->label,
            'to' => @$uship->route->items[1]->address->label,
            'length' => @$uship->route->distance->label,
            'price' => @$uship->price->label,
        ];*/

        /*var_dump($templateParams['uship']);
        die('f');*/

        /*if (@$_GET['mod'] == 'test') {
            return $this->displayTemplate("auctions_details_new.tpl", $templateParams);
        }

        if (@$_GET['mod'] == 'test2') {
            return $this->displayTemplate("auctions_details_new2.tpl", $templateParams);
        }*/
        return $this->displayTemplate("auctions_details_new2.tpl", $templateParams);
    }

    /**
     * Form submit accept the high bid
     */
    public function accept_high_bid(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['auction_id'])
            && $_POST['auction_id'] > 0 && !empty($_POST['accept_high_bid']) && intval($_POST['accept_high_bid']) === 1 ) {
            $max_id = FJF_BASE_RICH::getRecords("auctions_bids", "auction_id='" . $_POST['auction_id'] . "' and winning_bid=0 ",null,false,"MAX(id) as id");
            FJF_BASE_RICH::updateRecords("auctions_bids","winning_bid=1","id=MAX_ID",array('MAX_ID' => $max_id[0]->id));

        }
    }

    public function getUship($saller, $buyer, $car) {
        $grant_type = 'client_credentials';
        $client_id = 'b8xj2d8wkpk6ygwjm38t5tze';
        $client_secret = 'TgsaZgRvwm';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apistaging.uship.com/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=". $grant_type ."&client_id=". $client_id ."&client_secret=" . $client_secret,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: d6fcd518-ec1a-463d-ff03-f414d56e4dd9"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {
            $response = json_decode($response);
            $access_token = $response->access_token;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apistaging.uship.com/v2/estimate",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n      route: {\n        items: [\n          {\n            address: {\n              postalCode: \"$saller->zip\",\n              country: \"US\"\n            }\n          },\n          {\n            address: {\n              postalCode: \"$buyer->zip\",\n              country: \"US\"\n            }\n          }\n        ]\n      },\n      items: [\n        {\n          commodity: \"CarsLightTrucks\",\n          year: \"$car->year\",\n          makeName: \"$car->make\",\n          modelName: \"$car->model\"\n        }\n      ]\n    }",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: gzip, deflate",
                    "Authorization: Bearer " . $access_token,
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Content-Length: 472",
                    "Content-Type: application/json",
                    "Host: apistaging.uship.com",
                    "Postman-Token: 7f0db0e8-1ff2-4a32-abef-e226cf848283,78887ff5-4ead-4803-80f0-fe784661642a",
                    "User-Agent: PostmanRuntime/7.15.2",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if (!$err) {
                return json_decode($response);
            }
        }
        return (object)[];
    }
}

?>

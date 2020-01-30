<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");

class AccountBuyer extends FJF_CMD
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
        $isLoggedIn = SessionModel::isUser();
        $buyerID = ($isLoggedIn) ? SessionModel::loggedUserID() : 0;
        $buyerInfo = FJF_BASE_RICH::getRecord("users", "status = 1 AND user_type = 'Buyer' AND id = 'USER_ID'", array('USER_ID' => $buyerID));
        $mode = (isset($_GET["mode"])) ? trim($_GET["mode"]) : "";

        if (!$buyerInfo) {
            FJF_BASE::redirect("/");
        }

        // PAYMENTS

        $filter = isset($_REQUEST["filter"]) ? trim($_REQUEST["filter"]) : "";
        if ($filter == "paid") {
            $order = " AND status = 'paid'";
        } elseif ($filter == "refunded") {
            $order = " AND status = 'refunded'";
        } else {
            $order = "";
        }

        $limit = 25;

        $_SESSION["order"] = "1";
        $_SESSION["order"] = $order != "" ? $order : $_SESSION["order"];

        $sorting = isset($_REQUEST["sort"]) ? trim($_REQUEST["sort"]) : "";
        if ($sorting == "datetime_asc") {
            $sort = " ORDER BY datetime ASC";
        } elseif ($sorting == "datetime_desc") {
            $sort = " ORDER BY datetime DESC";
        } elseif ($sorting == "auction_name_asc") {
            $sort = " ORDER BY auction_name ASC";
        } elseif ($sorting == "auction_name_desc") {
            $sort = " ORDER BY auction_name DESC";
        } elseif ($sorting == "buyer_fee_asc") {
            $sort = " ORDER BY buyer_fee ASC";
        } elseif ($sorting == "buyer_fee_desc") {
            $sort = " ORDER BY buyer_fee DESC";
        } elseif ($sorting == "sale_price_asc") {
            $sort = " ORDER BY sale_price ASC";
        } elseif ($sorting == "sale_price_desc") {
            $sort = " ORDER BY sale_price DESC";
        } else {
            $sort = "ORDER BY id DESC";
        }
        $payments = FJF_BASE_RICH::getRecords("transactions", "buyer_id = 'USER_ID' " . $order . $sort, array('USER_ID' => $buyerID));

        if ($payments) {
            $auctionsIDs = array();
            foreach ($payments as $payment) {
                if (!in_array($payment->auction_id, $auctionsIDs)) $auctionsIDs[] = $payment->auction_id;
            }
            if ($auctionsIDs) {
                $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
                $paidAuctions = FJF_BASE_RICH::getRecords("auctions", "id IN(" . implode(',', $auctionsIDs) . ")");
                if ($paidAuctions) {
                    foreach ($payments as $payment) {
                        $paidAuction = array_key_exists($payment->auction_id, $paidAuctions) ? $paidAuctions[$payment->auction_id] : null;
                        if ($paidAuction) {
                            $payment->auction_year = $paidAuction->year;
                            $payment->auction_make = $paidAuction->make;
                            $payment->auction_model = $paidAuction->model;
                            $payment->buyer_fee_formatted = FJF_BASE::moneyFormat($payment->buyer_fee);
                            $payment->sale_price_formatted = FJF_BASE::moneyFormat($payment->sale_price);
                            $payment->auction_image = "";
                            if ($paidAuction->photos) {
                                $photos = json_decode($paidAuction->photos);
                                if ($photos && is_array($photos) && isset($photos[0]->photo)) $payment->auction_image = $photos[0]->photo;
                            }
                        }
                    }
                }
            }
        }

        if (isset($_REQUEST["filter"])) {
            $htmlList = $this->fetchTemplate("includes/main/buyer_payments.tpl", array("payments" => $payments));
            echo json_encode(array("html" => $htmlList));
            exit;
        }

        if (isset($_REQUEST["sort"])) {
            $htmlList = $this->fetchTemplate("includes/main/buyer_payments.tpl", array("payments" => $payments));
            echo json_encode(array("html" => $htmlList));
            exit;
        }

        // USERS BIDS
        $bids = $mode == 'bids' ? RecordsModel::getBuyerBids($buyerID) : null;
        $curren_bids = [];
        $uid = SessionModel::loggedUserID();
        if($bids != null){
          // echo "<pre>";
          // print_r($bids);
          // die;
          foreach ($bids as $key => $item) {
              $flag_big = [];
              if(is_array($item)){
                foreach ($item as $key1 => $item1) {

                  $auction_flag = FJF_BASE_RICH::getRecord("auctions", "id = 'auction_id'", array("auction_id" => $item1->auction_id));
                  $auction_win_big = FJF_BASE_RICH::getRecord("auctions_bids", "auction_id = ".$item1->auction_id." AND winning_bid = 1  ORDER BY `id` DESC", array());
                  $auction_higher_price = FJF_BASE_RICH::getRecord("auctions_bids", "auction_id = ".$item1->auction_id." ORDER BY `bid_price` DESC limit 1", array());
                  $auction_higher = FJF_BASE_RICH::getRecord("auctions_bids", "auction_id = ".$item1->auction_id." AND user_id = ".$buyerID." ORDER BY `id` DESC limit 1", array());

                  if($auction_higher){
                      $item1->bid_price = $auction_higher->bid_price;
                  }else{
                      $item1->bid_price = $item1->bid_price;
                  }

                  if($auction_higher){
                      $item1->bet_win_big = $auction_higher->maximum_proxy;
                  }else{
                      $item1->bet_win_big = "";
                  }

                  if($key == "current"){
                      if($auction_higher->bid_price < $auction_higher_price->bid_price){
                          $item1->bet_win = "Out Bid";
                      }else{
                          $item1->bet_win = "High Bidder";
                      }
                  }else{
                      if($uid != $auction_flag->winner_id && $auction_flag->winner_id != ''){
                          $item1->bet_win = "Lost";
                      }else if($uid == $auction_flag->winner_id && $auction_flag->winner_id != ''){
                          $transactions = FJF_BASE_RICH::getRecord("transactions", "auction_id = ".$item1->auction_id." AND buyer_id = ".$buyerID." ORDER BY `id` DESC limit 1", array());
                          if($transactions){
                              $item1->bet_win = "Won";
                          }else{
                              $item1->bet_win = "Lost";
                          }

                      }else{
                        $item1->bet_win = "Lost";
                      }
                  }



                  $sql = "SELECT ab.user_id,ab.auction_id, ab.datetime_create, ab.bid_price, a.id, a.make, a.model, a.year, a.photos";
                  $sql .= " FROM auctions_bids ab";
                  $sql .= " LEFT JOIN auctions a ON ab.auction_id = a.id";
                  // $sql .= " WHERE ab.user_id = 'USER_ID'";
                  $sql .= " WHERE ab.auction_id = 'AUCTIONS_ID'";
                  $sql .= " ORDER BY ab.datetime_create DESC ,a.expiration_date ASC ";
                  $list_detail = FJF_BASE_RICH::selectRecords($sql, array('USER_ID' => $buyerID , 'AUCTIONS_ID' => $item1->auction_id));

                  foreach ($list_detail as $value) {
                      $value->photos = json_decode($value->photos);
                      if(@$value->photos){
                          $value->auction_image = @$value->photos[0]->photo;
                      }
                      $value->photos = json_encode($value->photos);
                      // print_r($value);die;
                      if($value->user_id == $buyerID){
                          $value->this = 1;
                      }else{
                          $value->this = 0;
                      }
                  }
                  $item1->list_detail = $list_detail;
                  $flag_big[] = $item1;
                }
                $curren_bids[$key] = $flag_big;
              }else{
                  $curren_bids[$key] = $item;
              }


          }
          $bids = $curren_bids;
        }

        // END USERS BIDS

        // USERS WATCHED SELLERS
        $buyerWatchedSellers = array();
        $buyerFavoritesSellers = array();
        $usersWatchedSellers = FJF_BASE_RICH::getRecords("users_sellers_favorites", "user_id = 'USER_ID'", array('USER_ID' => $buyerID));
        $usersWatchedSellerIDs = array();
        if (!empty($usersWatchedSellers)) {
            foreach ($usersWatchedSellers as $usersWatchedSeller) {
                $usersWatchedSellerIDs[] = $usersWatchedSeller->seller_id;
            }
            $usersWatchedSellerIDs = implode(", ", $usersWatchedSellerIDs);
            $buyerWatchedSellers = FJF_BASE_RICH::getRecords("users", "id IN ($usersWatchedSellerIDs)");
            foreach ($buyerWatchedSellers as $buyerWatchedSeller) {
                $buyerWatchedSeller->distance = ($buyerWatchedSeller->lat != "" && $buyerWatchedSeller->lon != "" && $buyerInfo->lat != "" && $buyerInfo->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($buyerInfo->lat, $buyerInfo->lon, $buyerWatchedSeller->lat, $buyerWatchedSeller->lon, 3959) : "";

                $where = "user_id=" . $buyerWatchedSeller->id . " AND auction_status = 'Active'";
                $buyerWatchedSeller->auctions = RecordsModel::getAuctionsCount($where);
            }
            if ($buyerWatchedSellers && is_object($buyerInfo)) {
                $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "seller_id";
                $buyerFavoritesSellers = FJF_BASE_RICH::getRecords("users_sellers_favorites", "user_id=" . $buyerInfo->id);
                $buyerFavoritesSellers = $buyerFavoritesSellers ? array_keys($buyerFavoritesSellers) : array();
            }

        }
        // END USERS WATCHED SELLERS

        // USERS WATCHED LISTINGS
        $buyerWatchedListings = array();
        $usersWatchedListings = FJF_BASE_RICH::getRecords("users_favorites", "user_id = 'USER_ID'", array('USER_ID' => $buyerID));
        $usersWatchedListingIDs = array();
        if ($usersWatchedListings) {
            foreach ($usersWatchedListings as $usersWatchedListing) {
                $usersWatchedListingIDs[] = $usersWatchedListing->record_id;
            }
            $usersWatchedListingIDs = implode(", ", $usersWatchedListingIDs);
            $where = $wlWhere = "a.id IN (" . $usersWatchedListingIDs . ")";
            $buyerWatchedListings = RecordsModel::getAllAuctions($wlWhere, "", $limit, null, null);
            if ($buyerWatchedListings) {
                foreach ($buyerWatchedListings as $auction) {
                    $auction->hide_place_bid = "";
                    if ($buyerInfo->buyer_type == "Individual" && $auction->sell_to == 1) {
                        $auction->hide_place_bid = "Hide";
                    }
                    $auctionSellerInfo = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array('USER_ID' => $auction->user_id));
                    if (is_object($auctionSellerInfo)) {
                        $auction->distance_from_buyer_to_seller = ($auctionSellerInfo->lat != "" && $auctionSellerInfo->lon != "" && $buyerInfo->lat != "" && $buyerInfo->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($buyerInfo->lat, $buyerInfo->lon, $auctionSellerInfo->lat, $auctionSellerInfo->lon, 3959) : "";
                    }
                }
            }

            $userFavs = array();
            if ($buyerWatchedListings && is_object($buyerInfo)) {
                $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "record_id";
                $userFavs = FJF_BASE_RICH::getRecords("users_favorites", "user_id=" . $buyerInfo->id);
                $userFavs = $userFavs ? array_keys($userFavs) : array();
            }
        }
        // END USERS WATCHED LISTINGS

        $status = "";
        $hasError = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = (isset($_POST["action"])) ? trim($_POST["action"]) : "";
            if ($action == "upload_photo") {
                $result = 0;
                $folder = SiteMediaModel::getFolder("users-images");
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]) {
                    try {
                        $file = SiteMediaModel::uploadFile($folder, "file");
                        if ($file) {
                            $result = $file->id;
                            //$result["file_name"] = $file->name_orig;
                        } else {
                            $result = false;
                        }
                    } catch (Exception $e) {
                        //$result["error"] = true;
                        $result = false;
                    }
                }

                echo json_encode($result);
                return false;
            } elseif ($action == "upload_license") {
                $result = 0;
                $folder = SiteMediaModel::getFolder("licenses");
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]) {
                    try {
                        $file = SiteMediaModel::uploadFile($folder, "file");
                        if ($file) {
                            $result = $file->id;
                            //$result["file_name"] = $file->name_orig;
                        } else {
                            $result = false;
                        }
                    } catch (Exception $e) {
                        //$result["error"] = true;
                        $result = false;
                    }
                }

                echo json_encode($result);
                return false;
            }
            if ($action == "buyer-individual") {
                $fields["id"] = SessionModel::loggedUserID();
                $fields["name"] = (isset($_POST["name"])) ? htmlspecialchars(trim($_POST["name"])) : "";
                $fields["email"] = (isset($_POST["email"])) ? trim($_POST["email"]) : "";
                $fields["address"] = (isset($_POST["address"])) ? trim($_POST["address"]) : "";
                $fields["city"] = (isset($_POST["city"])) ? trim($_POST["city"]) : "";
                $fields["state"] = (isset($_POST["state"])) ? trim($_POST["state"]) : "";
                $fields["zip"] = (isset($_POST["zip"])) ? trim($_POST["zip"]) : "";
                $fields["mobile_number"] = (isset($_POST["mobile_number"])) ? trim($_POST["mobile_number"]) : "";
                $postDriversLicenseNumber = (isset($_POST["drivers_license_number"])) ? trim($_POST["drivers_license_number"]) : "";
                $fields["drivers_license_state"] = (isset($_POST["drivers_license_state"])) ? trim($_POST["drivers_license_state"]) : "";
                $dateOfBirth = (isset($_POST["date_of_birth"])) ? trim($_POST["date_of_birth"]) : "";
                $licenseIssueDate = (isset($_POST["license_issue_date"])) ? trim($_POST["license_issue_date"]) : "";
                $licenseExpirationDate = (isset($_POST["license_expiration_date"])) ? trim($_POST["license_expiration_date"]) : "";
                $fields["drivers_license_photo"] = (isset($_POST["drivers_license_photo"])) ? trim($_POST["drivers_license_photo"]) : "";

                $fields["pickup_transporter"] = (isset($_POST["pickup_transporter"])) ? trim($_POST["pickup_transporter"]) : "";
                $fields["pickup_address"] = (isset($_POST["pickup_address"])) ? trim($_POST["pickup_address"]) : "";
                $fields["pickup_city"] = (isset($_POST["pickup_city"])) ? trim($_POST["pickup_city"]) : "";
                $fields["pickup_state"] = (isset($_POST["pickup_state"])) ? trim($_POST["pickup_state"]) : "";
                $fields["pickup_zip"] = (isset($_POST["pickup_zip"])) ? trim($_POST["pickup_zip"]) : "";
                $fields["transporter_phone"] = (isset($_POST["transporter_phone"])) ? trim($_POST["transporter_phone"]) : "";
                $fields["pickup_driver"] = (isset($_POST["pickup_driver"])) ? trim($_POST["pickup_driver"]) : "";
                $fields["driver_phone"] = (isset($_POST["driver_phone"])) ? trim($_POST["driver_phone"]) : "";

                if ($buyerInfo->email != $fields["email"]) {
                    $userInfo = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL'", array("EMAIL_VAL" => $fields["email"]));
                    if (is_object($userInfo)) {
                        $hasError = true;
                        $status .= "Email already in use.<br />";
                    }
                    if (!$fields["email"]) {
                        $hasError = true;
                        $status .= "Email is missing.<br />";
                    } elseif (!preg_match("/^.+\@.+\..{2,}$/", $fields["email"])) {
                        $hasError = true;
                        $status .= "Invalid Email format.<br />";
                    }
                }

                if (!$fields["name"]) {
                    $hasError = true;
                    $status .= "Name is missing.<br/>";
                }

                if (!$fields["zip"]) {
                    $hasError = true;
                    $status .= "Zip Code is missing.<br/>";
                }

                if ($postDriversLicenseNumber == "") {
                    $hasError = true;
                    $status .= "DL number is missing.<br/>";
                } else {
                    if (strpos($postDriversLicenseNumber, "*") === false) {
                        $fields["drivers_license_number"] = FJF_BASE::encrypt($postDriversLicenseNumber, "drivers_license_number");
                    }
                }

                if (!$fields["drivers_license_state"]) {
                    $hasError = true;
                    $status .= "State is missing.<br/>";
                }
                if (!$dateOfBirth) {
                    $hasError = true;
                    $status .= "Date Of Birth is missing.<br/>";
                }
                if (isset($dateOfBirth) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dateOfBirth)) {
                    $hasError = true;
                    $status .= "Please enter the Date Of Birth in such 'mm.dd.yyyy' format.<br/>";
                } else {
                    $birthDateFormat = date_create_from_format('m.d.Y', $dateOfBirth);
                    $fields["date_of_birth"] = date_format($birthDateFormat, 'Y-m-d H:i:s');
                }
                if (!$licenseIssueDate) {
                    $hasError = true;
                    $status .= "Issue Date is missing.<br/>";
                }
                if (isset($licenseIssueDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $licenseIssueDate)) {
                    $hasError = true;
                    $status .= "Please enter the Issue Date in such 'mm.dd.yyyy' format.<br/>";
                } else {
                    $licenseIssueDateFormat = date_create_from_format('m.d.Y', $licenseIssueDate);
                    $fields["license_issue_date"] = date_format($licenseIssueDateFormat, 'Y-m-d H:i:s');
                }
                if ($licenseIssueDate && strtotime($fields["license_issue_date"]) > time()) {
                    $hasError = true;
                    $status .= "Issue Date must be in the past.<br/>";
                }
                if (!$licenseExpirationDate) {
                    $hasError = true;
                    $status .= "Expiration Date is missing.<br/>";
                }
                if (isset($licenseExpirationDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $licenseExpirationDate)) {
                    $hasError = true;
                    $status .= "Please enter the Expiration Date in such 'mm.dd.yyyy' format.<br/>";
                } else {
                    $licenseExpirationDateFormat = date_create_from_format('m.d.Y', $licenseExpirationDate);
                    $fields["license_expiration_date"] = date_format($licenseExpirationDateFormat, 'Y-m-d H:i:s');
                }
                if (isset($fields["license_expiration_date"]) && strtotime($fields["license_expiration_date"]) < time()) {
                    $hasError = true;
                    $status .= "Expiration Date must be in the future.<br/>";
                }
                if (!$fields["drivers_license_photo"]) {
                    $hasError = true;
                    $status .= "Drivers License is missing.<br/>";
                }

                if ($fields["zip"]) {
                    $latLon = RecordsModel::getCityStateByZip($fields["zip"]);
                }
                $fields["lat"] = is_array($latLon) ? $latLon["lat"] : "";
                $fields["lon"] = is_array($latLon) ? $latLon["lon"] : "";

                if (!$hasError) {
                    $fields["license_expired"] = 0;
                    if (!$hasError && FJF_BASE_RICH::updateRecord("users", $fields, "id")) {
                        $response["status"] = true;
                    }
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            } elseif ($action == "buyer-dealer") {
                $fields["id"] = SessionModel::loggedUserID();
                $fields["name"] = (isset($_POST["name"])) ? htmlspecialchars(trim($_POST["name"])) : "";
                $fields["email"] = (isset($_POST["email"])) ? trim($_POST["email"]) : "";
                $fields["address"] = (isset($_POST["address"])) ? trim($_POST["address"]) : "";
                $fields["mobile_number"] = (isset($_POST["mobile_number"])) ? trim($_POST["mobile_number"]) : "";
                $fields["city"] = (isset($_POST["city"])) ? trim($_POST["city"]) : "";
                $fields["state"] = (isset($_POST["state"])) ? trim($_POST["state"]) : "";
                $fields["zip"] = (isset($_POST["zip"])) ? trim($_POST["zip"]) : "";
                $fields["company_name"] = (isset($_POST["company_name"])) ? trim($_POST["company_name"]) : "";
                $fields["dealers_license_issued_to"] = (isset($_POST["dealers_license_issued_to"])) ? trim($_POST["dealers_license_issued_to"]) : "";
                $fields["dealers_license_state"] = (isset($_POST["dealers_license_state"])) ? trim($_POST["dealers_license_state"]) : "";
                $postDealersLicenseNumber = (isset($_POST["dealers_license_number"])) ? trim($_POST["dealers_license_number"]) : "";
                $dealersLicenseIssueDate = (isset($_POST["dealers_license_issue_date"])) ? trim($_POST["dealers_license_issue_date"]) : "";
                $dealersLicenseExpirationDate = (isset($_POST["dealers_license_expiration_date"])) ? trim($_POST["dealers_license_expiration_date"]) : "";
                $fields["dealers_license_photo"] = (isset($_POST["dealers_license_photo"])) ? trim($_POST["dealers_license_photo"]) : "";

                $fields["pickup_transporter"] = (isset($_POST["pickup_transporter"])) ? trim($_POST["pickup_transporter"]) : "";
                $fields["pickup_address"] = (isset($_POST["pickup_address"])) ? trim($_POST["pickup_address"]) : "";
                $fields["pickup_city"] = (isset($_POST["pickup_city"])) ? trim($_POST["pickup_city"]) : "";
                $fields["pickup_state"] = (isset($_POST["pickup_state"])) ? trim($_POST["pickup_state"]) : "";
                $fields["pickup_zip"] = (isset($_POST["pickup_zip"])) ? trim($_POST["pickup_zip"]) : "";
                $fields["transporter_phone"] = (isset($_POST["transporter_phone"])) ? trim($_POST["transporter_phone"]) : "";
                $fields["pickup_driver"] = (isset($_POST["pickup_driver"])) ? trim($_POST["pickup_driver"]) : "";
                $fields["driver_phone"] = (isset($_POST["driver_phone"])) ? trim($_POST["driver_phone"]) : "";

                $fields["cc_exp_month"] = (isset($_POST["card_month"])) ? trim($_POST["card_month"]) : "";
                $fields["cc_exp_year"] = (isset($_POST["card_year"])) ? trim($_POST["card_year"]) : "";

                if ($buyerInfo->email != $fields["email"]) {
                    $userInfo = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL'", array("EMAIL_VAL" => $fields["email"]));
                    if (is_object($userInfo)) {
                        $hasError = true;
                        $status .= "Email already in use.<br />";
                    }
                    if (!$fields["email"]) {
                        $hasError = true;
                        $status .= "Email is missing.<br />";
                    } elseif (!preg_match("/^.+\@.+\..{2,}$/", $fields["email"])) {
                        $hasError = true;
                        $status .= "Invalid Email format.<br />";
                    }
                }
                if (!$fields["name"]) {
                    $hasError = true;
                    $status .= "Name is missing.<br/>";
                }

                if (!$fields["zip"]) {
                    $hasError = true;
                    $status .= "Zip Code is missing.<br/>";
                }

                if (!$fields["dealers_license_state"]) {
                    $hasError = true;
                    $status .= "Dealers License State is missing.<br/>";
                }

                if ($postDealersLicenseNumber == "") {
                    $hasError = true;
                    $status .= "Dealers License Number is missing.<br/>";
                } else {
                    if (strpos($postDealersLicenseNumber, "*") === false) {
                        $fields["dealers_license_number"] = FJF_BASE::encrypt($postDealersLicenseNumber, "dealers_license_number");
                    }
                }

                if (!$dealersLicenseIssueDate) {
                    $hasError = true;
                    $status .= "Dealers Issue Date is missing.<br/>";
                }
                if (isset($dealersLicenseIssueDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseIssueDate)) {
                    $hasError = true;
                    $status .= "'Dealers Issue Date' invalid date format.<br/>";
                } else {
                    $dealersLicenseIssueDateFormat = date_create_from_format('m.d.Y', $dealersLicenseIssueDate);
                    $fields["dealers_license_issue_date"] = date_format($dealersLicenseIssueDateFormat, 'Y-m-d H:i:s');
                }
                if (isset($fields["dealers_license_issue_date"]) && strtotime($fields["dealers_license_issue_date"]) > time()) {
                    $hasError = true;
                    $status .= "Issue Date must be in the past.<br/>";
                }

                if (!$fields["dealers_license_issued_to"]) {
                    $hasError = true;
                    $status .= "Dealers License Issued To is missing.<br/>";
                }

                if (!$dealersLicenseExpirationDate) {
                    $hasError = true;
                    $status .= "Dealers Expiration Date is missing.<br/>";
                }
                if (isset($dealersLicenseExpirationDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseExpirationDate)) {
                    $hasError = true;
                    $status .= "'Dealers Expiration Date' invalid date format.<br/>";
                } else {
                    $dealersLicenseExpirationDateFormat = date_create_from_format('m.d.Y', $dealersLicenseExpirationDate);
                    $fields["dealers_license_expiration_date"] = date_format($dealersLicenseExpirationDateFormat, 'Y-m-d H:i:s');
                }
                if (isset($fields["dealers_license_expiration_date"]) && strtotime($fields["dealers_license_expiration_date"]) < time()) {
                    $hasError = true;
                    $status .= "Dealers Expiration Date must be in the future.<br/>";
                }
                if (!$fields["dealers_license_photo"]) {
                    $hasError = true;
                    $status .= "Dealers License Photo is missing .<br/>";
                }

                if ($fields["zip"] != "") {
                    $location = RecordsModel::getCityStateByZip($fields["zip"]);
                    if (!empty($location)) {
                        $fields["lat"] = $location["lat"];
                        $fields["lon"] = $location["lon"];
                        $fields["city"] = $location["city"];
                        $fields["state"] = $location["state"];
                        $fields["timezone"] = RecordsModel::getTimeZone($location["lat"] . "," . $location["lon"]);
                    }
                } else {
                    $fields["lat"] = "";
                    $fields["lon"] = "";
                    $fields["city"] = "";
                    $fields["state"] = "";
                    $fields["timezone"] = "";
                }

                if (!$hasError) {
                    $fields["license_expired"] = 0;

                    if (!$hasError && FJF_BASE_RICH::updateRecord("users", $fields, "id")) {
                        $response["status"] = true;
                        $_SESSION["user"]->name = $fields["name"];
                        $_SESSION["user"]->company_name = $fields["company_name"];
                    }
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            }
        }

        if ($buyerInfo->dealers_license_photo) {
            $buyerInfo->dealers_license_photo_info = SiteMediaModel::getFile($buyerInfo->dealers_license_photo);
        }
        if ($buyerInfo->drivers_license_photo) {
            $buyerInfo->drivers_license_photo_info = SiteMediaModel::getFile($buyerInfo->drivers_license_photo);
        }

        $driversLicenseNumber = ($buyerInfo->drivers_license_number != "") ? FJF_BASE::decrypt($buyerInfo->drivers_license_number, "drivers_license_number") : "";
        $buyerInfo->drivers_license_number = ($driversLicenseNumber != "") ? "********" . substr($driversLicenseNumber, -4) : "";

        $dealersLicenseNumber = ($buyerInfo->dealers_license_number != "") ? FJF_BASE::decrypt($buyerInfo->dealers_license_number, "dealers_license_number") : "";
        $buyerInfo->dealers_license_number = ($dealersLicenseNumber != "") ? "********" . substr($dealersLicenseNumber, -4) : "";

        $userContentBlocks = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type='Payment/Pickup' AND status=1 AND approved=1 AND user_id='USER_ID'", array("USER_ID" => $buyerInfo->id));

        if ($this->isAjax() && !empty($buyerWatchedListings)) {
            $action = isset($_REQUEST["act"]) ? trim($_REQUEST["act"]) : "";
            $data = array();
            $manager = new stdClass;
            $manager->total = RecordsModel::getAllAuctionsCount($wlWhere);
            $manager->limit = $limit;
            $manager->total_pages = ceil($manager->total / $manager->limit);
            $manager->page = isset($_REQUEST['page']) && $_REQUEST['page'] > 1 ? intval($_REQUEST['page']) : 1;
            $manager->offset = $manager->limit * ($manager->page - 1);
            $limit = $manager->offset . ", " . $manager->limit;
            $buyerWatchedListings = RecordsModel::getAllAuctions($wlWhere, "", $limit, null, null);
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($buyerWatchedListings) {
                $data['html'] = $this->fetchTemplate("buyer_watched_listings.tpl", array(
                    "manager" => $manager,
                    "buyer_watched_listings" => $buyerWatchedListings,
                    "user_favs" => $userFavs,
                    "user" => isset($user) ? $user : null
                ));
            }
            exit(json_encode($data));
            return true;
        }

        $states = FJF_BASE_RICH::getRecords("states");
        $this->pageModel->setMetadata("title", $buyerInfo->name);

        return $this->displayTemplate("account_buyer.tpl", array(
            "body_class" => "t2",
            "account_info" => $buyerInfo,
            "states" => $states,
            "buyer_watched_sellers" => (isset($buyerWatchedSellers) ? $buyerWatchedSellers : null),
            "buyer_favorites_sellers" => (isset($buyerFavoritesSellers) ? $buyerFavoritesSellers : null),
            "buyer_watched_listings" => (isset($buyerWatchedListings) ? $buyerWatchedListings : null),
            "user_favs" => (isset($userFavs) ? $userFavs : null),
            "payments" => (isset($payments) ? $payments : null),
            "payments_pickup" => (isset($userContentBlocks) ? $userContentBlocks : null),
            "mode" => $mode,
            "bids" => $bids
        ));
    }

}

?>

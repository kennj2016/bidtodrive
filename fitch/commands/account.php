<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class Account extends FJF_CMD
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
        $successMessage = false;
        $status = "";

        $userID = SessionModel::loggedUserID();
        $userType = SessionModel::getUserType();
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);

        if ($userType != "Seller") {
            FJF_BASE::redirect("/account/buyer/");
        }

        RecordsModel::autoUpdateStatusAuction($userID);

        $limit = 25;
        $action = isset($_REQUEST["action"]) ? trim($_REQUEST["action"]) : "";
        $sort = isset($_REQUEST["sort"]) ? trim($_REQUEST["sort"]) : "";
        $auctionStatus = (isset($_REQUEST["auction_status"]) && trim($_REQUEST["auction_status"]) != "") ? trim($_REQUEST["auction_status"]) : "Active";
        if ($sort == "1") {
            $order = "a.expiration_date";
        } elseif ($sort == "2") {
            $order = "distance";
        } elseif ($sort == "3") {
            $order = "a.mileage";
        } elseif ($sort == "4") {
            $order = "a.mileage DESC";
        } elseif ($sort == "5") {
            $order = "a.year DESC";
        } elseif ($sort == "6") {
            $order = "a.year";
        } elseif ($sort == "7") {
            $order = "current_bid_price";
        } elseif ($sort == "8") {
            $order = "current_bid_price DESC";
        } else {
            $order = "a.datetime_create DESC";
        }
        $where = "a.user_id = '" . $userID . "'";
        if ($auctionStatus != "" && $auctionStatus != 'total') {
            if ($auctionStatus == 'Unsold') {
                $where .= " AND a.auction_status != 'Canceled' AND  a.auction_status != 'Sold'";
            } else {
                $where .= " AND a.auction_status = '" . $auctionStatus . "'";
            }
        }

        if ($action == "load_more") {
            $data = array();
            $manager = new stdClass;
            $manager->total = RecordsModel::getAllAuctionsCount("a.user_id = '" . $userID . "'");
            $manager->limit = $limit;
            $manager->total_pages = ceil($manager->total / $manager->limit);
            $manager->page = isset($_REQUEST['page']) && $_REQUEST['page'] > 1 ? intval($_REQUEST['page']) : 1;
            $manager->offset = $manager->limit * ($manager->page - 1);
            $limit = $manager->offset . ", " . $manager->limit;
            $auctions = RecordsModel::getAllAuctions($where, "", $limit, $order, null);
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if($auctions){
                $data['html'] = $this->fetchTemplate("seller_watched_auction_list.tpl", array(
                "manager" => $manager,
                "auctions" => $auctions
                ));
            }
            exit(json_encode($data));
            return true;
        }else{
            if(isset($_REQUEST["auction_status"]) || isset($_REQUEST["sort"])){
                $auctions = RecordsModel::getAllAuctions($where, "", $limit, $order, null);
                // echo "<pre>";
                // print_r($userID);die;
                $flag_return = [];
                foreach ($auctions as $key => $value) {
                  // code...
                  $this_time = time()-(60*60*24);
                  if($value->auction_completion_date != ''){
                      if($this_time < strtotime($value->auction_completion_date)){
                          $value->show_accept = 1;
                      }else{
                        $value->show_accept = 0;
                      }
                  }else{
                      if($this_time < strtotime($value->expiration_date)){
                          // echo " co";
                          $value->show_accept = 1;
                      }else{
                        // echo "khong";
                        $value->show_accept = 0;
                      }
                  }
                  if($value->auction_status == "Sold"){
                      $buyer = FJF_BASE_RICH::getRecord("transactions", "auction_id = ".$value->id." limit 1", array());
                      if($buyer){
                          $value->buyer = $buyer;
                      }else{
                          $value->buyer = 0;
                      }
                  }
                  $auction_higher_price = FJF_BASE_RICH::getRecord("auctions_bids", "auction_id = ".$value->id." ORDER BY `bid_price` DESC limit 1", array());
                  // echo "<pre>";
                  // print_r($auction_higher_price);die;
                  if($auction_higher_price){
                      $value->higher_price = $auction_higher_price->bid_price;
                  }else{
                      $value->higher_price = 0;
                      $value->show_accept = 0;
                      // $value->show_accept = 0;
                  }
                  $flag_return[$key] = $value;
                }
                $auctions = $flag_return;

                $data['html'] = $this->fetchTemplate("seller_watched_auction_list.tpl", array(
                    "auctions" => $auctions
                ));
                exit(json_encode($data));
                return true;
            }else{
                $auctions = RecordsModel::getAllAuctions($where, "", null, $order, null);

            }

        }


        $sellerAuctionsStatuses = RecordsModel::getSellerAuctionsStatuses("a.user_id = '" . $userID . "'");
        $auctionsStatuses = array();
        if ($sellerAuctionsStatuses) {
            foreach ($sellerAuctionsStatuses as $a) {
                if ($a->auction_status) {
                    if (!array_key_exists($a->auction_status, $auctionsStatuses)) $auctionsStatuses[$a->auction_status] = 0;
                    $auctionsStatuses[$a->auction_status]++;
                }
            }
            if ($auctionsStatuses) ksort($auctionsStatuses);
        }
        $auctionsStatusesTotal = array_sum($auctionsStatuses);
        $countSold = 0;
        foreach ($auctionsStatuses as $k => $v) {
            if ($k == 'Canceled' || $k == 'Sold') {
                $countSold += $v;
            }
        }
        $countUnSold = $auctionsStatusesTotal - $countSold;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($action == "upload_photo") {
                $result = 0;
                $folder = SiteMediaModel::getFolder("users-images");
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]) {
                    try {
                        $file = SiteMediaModel::uploadFile($folder, "file");
                        if ($file) {
                            $result = $file->id;
                        } else {
                            $result = false;
                        }
                    } catch (Exception $e) {
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
                        } else {
                            $result = false;
                        }
                    } catch (Exception $e) {
                        $result = false;
                    }
                }

                echo json_encode($result);
                return false;
            }

            $user->name = isset($_REQUEST["name"]) ? trim($_REQUEST["name"]) : '';
            $user->url_title = strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $user->name), "-"));
            $user->email = isset($_REQUEST["email"]) ? trim($_REQUEST["email"]) : "";
            $user->address = isset($_REQUEST["address"]) ? trim($_REQUEST["address"]) : "";
            $user->mobile_number = isset($_REQUEST["mobile_number"]) ? trim($_REQUEST["mobile_number"]) : '';
            $user->city = (isset($_REQUEST["city"])) ? trim($_REQUEST["city"]) : "";
            $user->zip = (isset($_REQUEST["zip"])) ? trim($_REQUEST["zip"]) : "";
            $user->state = (isset($_REQUEST["state"])) ? trim($_REQUEST["state"]) : "";
            $user->dealers_license_issued_to = (isset($_REQUEST["dealers_license_issued_to"])) ? trim($_REQUEST["dealers_license_issued_to"]) : "";
            $user->dealers_license_state = (isset($_REQUEST["dealers_license_state"])) ? trim($_REQUEST["dealers_license_state"]) : "";
            $postDealersLicenseNumber = (isset($_POST["dealers_license_number"])) ? trim($_POST["dealers_license_number"]) : "";

            $user->profile_photo = (isset($_REQUEST["profile_photo"])) ? intval($_REQUEST["profile_photo"]) : 0;
            $user->dealers_license_photo = (isset($_REQUEST["dealers_license_photo"])) ? intval($_REQUEST["dealers_license_photo"]) : 0;

            $dealersLicenseIssueDate = (isset($_REQUEST["dealers_license_issue_date"])) ? trim($_REQUEST["dealers_license_issue_date"]) : "";
            $dealersLicenseExpirationDate = (isset($_REQUEST["dealers_license_expiration_date"])) ? trim($_REQUEST["dealers_license_expiration_date"]) : "";

            if (!$user->name) {
                $hasError = true;
                $status .= "Name is missing.<br/>";
            }
            if (!$user->zip) {
                $hasError = true;
                $status .= "Zip is missing.<br/>";
            }
            if (!$user->email) {
                $hasError = true;
                $status .= "Email is missing.<br/>";
            } elseif (FJF_BASE_RICH::getRecords("users", "email='" . $user->email . "' AND id<>" . $user->id)) {
                $hasError = true;
                $status .= "Email already in use.<br />";
            }
            if (!$user->dealers_license_issued_to) {
                $hasError = true;
                $status .= "Dealers License Issued To is missing.<br/>";
            }
            if (!$user->dealers_license_state) {
                $hasError = true;
                $status .= "Dealers License State is missing.<br/>";
            }
            if ($postDealersLicenseNumber == "") {
                $hasError = true;
                $status .= "Dealers License Number is missing.<br/>";
            } else {
                if (strpos($postDealersLicenseNumber, "*") === false) {
                    $user->dealers_license_number = FJF_BASE::encrypt($postDealersLicenseNumber, "dealers_license_number");
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
                $user->dealers_license_issue_date = date_format($dealersLicenseIssueDateFormat, 'Y-m-d H:i:s');
            }
            if (isset($user->dealers_license_issue_date) && strtotime($user->dealers_license_issue_date) > time()) {
                $hasError = true;
                $status .= "Issue Date must be in the past.<br/>";
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
                $user->dealers_license_expiration_date = date_format($dealersLicenseExpirationDateFormat, 'Y-m-d H:i:s');
            }
            if (isset($user->dealers_license_expiration_date) && strtotime($user->dealers_license_expiration_date) < time()) {
                $hasError = true;
                $status .= "Dealers Expiration Date must be in the future.<br/>";
            }
            if (!$user->dealers_license_photo) {
                $hasError = true;
                $status .= "Dealers License is missing.<br/>";
            }

            $latLon = null;
            if ($user->zip != "") {
                $location = RecordsModel::getCityStateByZip($user->zip);
                if (!empty($location)) {
                    $user->lat = $location["lat"];
                    $user->lon = $location["lon"];
                    $user->city = $location["city"];
                    $user->state = $location["state"];
                    $user->timezone = RecordsModel::getTimeZone($location["lat"] . "," . $location["lon"]);
                }
            } else {
                $user->lat = "";
                $user->lon = "";
                $user->city = "";
                $user->state = "";
                $fields["city"] = "";
                $fields["state"] = "";
                $user->timezone = "";
            }

            if (!$hasError) {
                $user->license_expired = 0;
                if (!FJF_BASE_RICH::saveRecord("users", get_object_vars($user))) {
                    $hasError = true;
                    $status = "An error occurred while saving info.";
                } else {
                    $hasError = true;
                    $successMessage = true;
                    $status = "Your account was updated successfully.";
                }
            }
        }
        if ($user->profile_photo) {
            $user->profile_photo_info = SiteMediaModel::getFile($user->profile_photo);
        }
        if ($user->dealers_license_photo) {
            $user->dealers_license_photo_info = SiteMediaModel::getFile($user->dealers_license_photo);
        }

        $dealersLicenseNumber = ($user->dealers_license_number != "") ? FJF_BASE::decrypt($user->dealers_license_number, "dealers_license_number") : "";
        $user->dealers_license_number = ($dealersLicenseNumber != "") ? "********" . substr($dealersLicenseNumber, -4) : "";

        $termsConditions = $contentBlocks["terms"] = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type='Terms & Conditions' AND user_id=" . $userID . " AND status=1 AND approved=1 ORDER BY position DESC");
        $fees = $contentBlocks["fees"] = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type='Additional Fees' AND user_id=" . $userID . " AND status=1 AND approved=1 ORDER BY position DESC");
        $paymentPickups = $contentBlocks["payment_pickup"] = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type='Payment/Pickup' AND user_id=" . $userID . " AND status=1 AND approved=1 ORDER BY position DESC");

        $this->pageModel->setMetadata("title", "Account");

        return $this->displayTemplate("account_seller.tpl", array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
            "succes_message" => $successMessage,
            "action" => $action,
            "states" => FJF_BASE_RICH::getRecords("states"),
            "content_blocks" => (isset($contentBlocks) ? $contentBlocks : null),
            "auctions" => (isset($auctions) ? $auctions : null),
            "auctions_statuses" => $auctionsStatuses,
            "auction_info" => (isset($auctionInfo) ? $auctionInfo : null),
            "auction_fees" => (isset($fees) ? $fees : null),
            "terms_conditions" => (isset($termsConditions) ? $termsConditions : null),
            'auctionsStatusesTotal' => $auctionsStatusesTotal,
            'countUnSold' => $countUnSold
        ));
    }

}

?>

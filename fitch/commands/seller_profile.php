<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class SellerProfile extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        $urlTitle = isset($_REQUEST["url_title"]) ? trim($_REQUEST["url_title"]) : "";

        $sellerInfo = FJF_BASE_RICH::getRecord("users", "status = 1 AND url_title = 'URL_TITLE'", array("URL_TITLE" => $urlTitle));
        if (!$sellerInfo) {
            FJF_BASE::redirect("/auctions/");
        }
        $where = "";
        $userFavSellers = array();
        $isLoggedIn = SessionModel::isUser();
        $userID = ($isLoggedIn) ? SessionModel::loggedUserID() : 0;
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);
        if ($sellerInfo && is_object($user)) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "seller_id";
            $userFavSellers = FJF_BASE_RICH::getRecords("users_sellers_favorites", "user_id=" . $user->id);
        }
        $userFavSellers = $userFavSellers ? array_keys($userFavSellers) : array();

        if (is_object($sellerInfo) && $sellerInfo->lat != "" && $sellerInfo->lon != "") {
            if (is_object($user)) {
                if (!$user->lat && !$user->lon) {
                    $latLon = RecordsModel::getLatLon($user->zip);
                    $user->lat = $latLon["lat"];
                    $user->lon = $latLon["lon"];
                }
                $sellerInfo->distance = ($user->lat != "" && $user->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($user->lat, $user->lon, $sellerInfo->lat, $sellerInfo->lon, 3959) : "";
            } else {
                $latLon = RecordsModel::getLatLonByIP();
                $sellerInfo->distance = ($latLon["lat"] != "" && $latLon["lon"] != "") ? RecordsModel::getDistanceFromBuyerToSeller($latLon["lat"], $latLon["lon"], $sellerInfo->lat, $sellerInfo->lon, 3959) : "";
            }
        }

        $where = !$isLoggedIn || $isLoggedIn && $sellerInfo->id != $userID ? "user_id=" . $sellerInfo->id : "user_id=" . $sellerInfo->id;

        $countRecords = RecordsModel::getAllAuctionsCount($where);
        $records = $countRecords ? RecordsModel::getAllAuctions($where) : null;

        $userFavs = array();
        if ($records && is_object($user)) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "record_id";
            $userFavs = FJF_BASE_RICH::getRecords("users_favorites", "user_id=" . $user->id);
            $userFavs = $userFavs ? array_keys($userFavs) : array();
        }

        $filters = array(
            "make" => array(),
            "model" => array(),
            "price" => array(),
            "color" => array(),
            "year" => array(),
            "mileage" => array(),
        );
        $allRecords = RecordsModel::getAuctions($where);
        if ($allRecords) {
            foreach ($allRecords as $record) {
                if ($record->current_bid_price) {
                    $filters["price"][] = $record->current_bid_price;
                }
                if ($record->year) {
                    $filters["year"][] = $record->year;
                }
                if ($record->mileage) {
                    $filters["mileage"][] = $record->mileage;
                }
                if ($record->make && !array_key_exists($record->make, $filters["make"])) {
                    $filters["make"][$record->make] = array("name" => $record->make, "count" => 1, "selected" => 0);
                } elseif ($record->model) {
                    $filters["make"][$record->make]["count"]++;
                }
                if ($record->model && $record->make && !array_key_exists($record->model . "__" . $record->make, $filters["model"])) {
                    $filters["model"][$record->model . "__" . $record->make] = array("name" => $record->model, "make" => $record->make, "count" => 1, "selected" => 0);
                } elseif ($record->model && $record->make) {
                    $filters["model"][$record->model . "__" . $record->make]["count"]++;
                }
                if ($record->color && !array_key_exists($record->color, $filters["color"])) {
                    $filters["color"][$record->color] = array("name" => $record->color, "count" => 1, "selected" => 0);
                } elseif ($record->color) {
                    $filters["color"][$record->color]["count"]++;
                }
            }
        }

        if ($filters["year"] && !empty($filters["year"])) {

            $minYear = min(array_values($filters["year"]));
            $maxYear = max(array_values($filters["year"]));
            $filters["year"] = array();
            $filters["year"]["min"] = round($minYear);
            $filters["year"]["max"] = round($maxYear);
            if ($filters["year"]["min"] == $filters["year"]["max"]) {
                $filters["year"]["max"]++;
            }
        } else {
            $filters["year"]["min"] = "0";
            $filters["year"]["max"] = "1";
        }
        if ($filters["mileage"] && !empty($filters["mileage"])) {
            $minMileage = min(array_values($filters["mileage"]));
            $maxMileage = max(array_values($filters["mileage"]));
            $filters["mileage"] = array();
            $filters["mileage"]["min"] = round($minMileage);
            $filters["mileage"]["max"] = round($maxMileage);
            if ($filters["mileage"]["min"] == $filters["mileage"]["max"]) {
                $filters["mileage"]["max"]++;
            }
        } else {
            $filters["mileage"]["min"] = "0";
            $filters["mileage"]["max"] = "1";
        }
        if ($filters["price"] && !empty($filters["price"])) {
            $minPrice = min(array_values($filters["price"]));
            $maxPrice = max(array_values($filters["price"]));
            $filters["price"] = array();
            $filters["price"]["min"] = round($minPrice);
            $filters["price"]["max"] = round($maxPrice);
            if ($filters["price"]["min"] == $filters["price"]["max"]) {
                $filters["price"]["max"]++;
            }
        } else {
            $filters["price"]["min"] = "0";
            $filters["price"]["max"] = "1";
        }
        if ($filters["model"] && !empty($filters["model"])) {
            $filters["model_json"] = json_encode($filters["model"]);
        } else {
            $filters["model_json"] = null;
        }
        if ($filters["make"] && !empty($filters["make"])) {
            $filters["make_json"] = json_encode($filters["make"]);
        } else {
            $filters["make_json"] = null;
        }
        if ($filters["color"] && !empty($filters["color"])) {
            $filters["color_json"] = json_encode($filters["color"]);
        } else {
            $filters["color_json"] = null;
        }

        $filters["title_wait_times"] = array("Title Available", "Up to 30 Days");
        $filters["states"] = FJF_BASE_RICH::getRecords("states");
        $filters["miles"] = array(5, 10, 20, 50, 75, 100, 200, 500);
        $filters["number_of_cylinders"] = array(1, 2, 3, 4, 6, 8, 10, 12, 14, 16);

        $auctionsStatuses = array();
        if ($records) {
            foreach ($records as $a) {
                if ($a->auction_status) {
                    if ($a->auction_status == "Refunded") {
                        $a->auction_status = "Sold";
                    }
                    if (!array_key_exists($a->auction_status, $auctionsStatuses)) $auctionsStatuses[$a->auction_status] = 0;
                    $auctionsStatuses[$a->auction_status]++;
                }
                $a->distance_from_buyer_to_seller = "";
                if (is_object($sellerInfo) && is_object($user)) {
                    $a->distance_from_buyer_to_seller = ($sellerInfo->lat != "" && $sellerInfo->lon != "" && $user->lat != "" && $user->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($user->lat, $user->lon, $sellerInfo->lat, $sellerInfo->lon, 3959) : "";
                }
            }
            if ($auctionsStatuses) ksort($auctionsStatuses);
        }

        $this->pageModel->setMetadata("title", "Seller - " . $sellerInfo->name);
        return $this->displayTemplate("seller_profile.tpl", array(
            "body_class" => "t2",
            "record" => $sellerInfo,
            "user_fav_sellers" => $userFavSellers,
            "records" => $records,
            "count_records" => $countRecords,
            "filters" => $filters,
            "user_favs" => $userFavs,
            "auctions_statuses" => $auctionsStatuses,
            "user" => is_object($user) ? $user : null
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class Auctions extends FJF_CMD
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
        //  Paginate
        $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
        if ($page == 1) {
            //$limit = 21;
            $limit = 11;
        } else {
            //$limit = 20;
            $limit = 10;
        }
        if ($page != 1) {
            $offset = $limit * ($page - 1) + 1;
        } else {
            $offset = $limit * ($page - 1);
        }
        $sqlLimit = $offset . ", " . $limit;


        $this->pageModel->setMetadata("title", "Auctions");

        $userFavs = array();
        $isLoggedIn = SessionModel::isUser();
        $userID = ($isLoggedIn) ? SessionModel::loggedUserID() : 0;
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);
        if ($user) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "record_id";
            $userFavs = FJF_BASE_RICH::getRecords("users_favorites", "user_id=" . $user->id);
            $userFavs = $userFavs ? array_keys($userFavs) : array();
        }
        $exteriorColors = array_flip($GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"]);

        $having = "";
        $action = isset($_REQUEST["action"]) ? trim($_REQUEST["action"]) : "";
        $sort = isset($_REQUEST["sort"]) ? trim($_REQUEST["sort"]) : "";
        $keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"], " \"'") : "";
        $sellerName = isset($_REQUEST["seller_name"]) ? trim($_REQUEST["seller_name"], " \"'") : "";
        $make = isset($_REQUEST["make"]) ? trim($_REQUEST["make"]) : "";
        $model = isset($_REQUEST["model"]) ? trim($_REQUEST["model"]) : "";
        $yearFrom = isset($_REQUEST["year_from"]) ? trim($_REQUEST["year_from"]) : "";
        $yearTo = isset($_REQUEST["year_to"]) ? trim($_REQUEST["year_to"]) : "";
        $priceFrom = isset($_REQUEST["price_from"]) ? trim($_REQUEST["price_from"]) : "";
        $priceTo = isset($_REQUEST["price_to"]) ? trim($_REQUEST["price_to"]) : "";
        $buyItNowOnly = (isset($_REQUEST["buy_it_now_only"]) && intval($_REQUEST["buy_it_now_only"]) == 1) ? 1 : 0;
        $mileageFrom = isset($_REQUEST["mileage_from"]) ? trim($_REQUEST["mileage_from"]) : "";
        $mileageTo = isset($_REQUEST["mileage_to"]) ? trim($_REQUEST["mileage_to"]) : "";
        $numberOfCylinders = isset($_REQUEST["number_of_cylinders"]) ? trim($_REQUEST["number_of_cylinders"]) : "";
        $transmission = isset($_REQUEST["transmission"]) ? trim($_REQUEST["transmission"]) : "";
        $colors = isset($_REQUEST["colors"]) ? $_REQUEST["colors"] : array();
        $titleWaitTimes = isset($_REQUEST["title_wait_times"]) ? trim($_REQUEST["title_wait_times"]) : "";
        $cityZip = isset($_REQUEST["city_zip"]) ? trim($_REQUEST["city_zip"]) : "";
        $state = isset($_REQUEST["state"]) ? trim($_REQUEST["state"]) : "";
        $milesRadius = isset($_REQUEST["miles"]) ? trim($_REQUEST["miles"]) : "";

        $sellerID = isset($_REQUEST["seller_id"]) ? trim($_REQUEST["seller_id"]) : false;

        if (is_object($user)) {
            if ($sellerID || $user->user_type == 'Seller') {
                if ($sellerID) {
                    //$where = "a.user_id=" . $sellerID . " AND a.auction_status = 'Active'";
                    $where = "a.auction_status = 'Active'";
                } else {
                    //$where = "a.created_by = " . $user->id . " AND a.auction_status = 'Active'";
                    $where = "a.auction_status = 'Active'";
                }
            } elseif($user->user_type == 'Buyer') {
                $where = "a.auction_status = 'Active'";
            }
        } else {
            $where = "a.auction_status = 'Active'";
        }

        if ($keyword) {
            $where .= " AND (a.title LIKE '%" . $keyword . "%' OR a.vin_number LIKE '%" . $keyword . "%' OR a.make LIKE '%" . $keyword . "%' OR a.model LIKE '%" . $keyword . "%' OR a.year LIKE '%" . $keyword . "%' OR a.engine LIKE '%" . $keyword . "%' OR a.options LIKE '%" . $keyword . "%' OR a.transmission LIKE '%" . $keyword . "%' OR a.mpg LIKE '%" . $keyword . "%' OR a.title_status LIKE '%" . $keyword . "%' OR a.mileage LIKE '%" . $keyword . "%' OR a.fuel_type LIKE '%" . $keyword . "%' OR a.trim LIKE '%" . $keyword . "%' OR a.trim2 LIKE '%" . $keyword . "%')";
        }
        if ($sellerName) {
            $where .= " AND (u.name LIKE '%" . $sellerName . "%')";
        }
        if ($make) {
            $where .= " AND (a.make='" . $make . "')";
        }
        if ($model) {
            $model = explode("__", $model);
            $modelModel = isset($model[0]) ? $model[0] : "";
            $modelMake = isset($model[1]) ? $model[1] : "";
            $where .= " AND (a.make='" . $modelMake . "' AND a.model='" . $modelModel . "')";
        }
        if ($yearFrom) {
            $where .= " AND (a.year >= " . $yearFrom . ")";
        }
        if ($yearTo) {
            $where .= " AND (a.year <= " . $yearTo . ")";
        }

        if ($mileageFrom) {
            $where .= " AND (a.mileage >= " . $mileageFrom . ")";
        }
        if ($mileageTo) {
            $where .= " AND (a.mileage <= " . $mileageTo . ")";
        }
        if ($numberOfCylinders) {
            $where .= " AND (a.number_of_cylinders = " . $numberOfCylinders . ")";
        }
        if ($transmission) {
            $where .= " AND (a.transmission = '" . $transmission . "')";
        }
        if ($titleWaitTimes) {
            $where .= " AND (a.title_wait_time = '" . $titleWaitTimes . "')";
        }
        if ($colors && !empty($colors)) {
            $colorsTitles = array();
            foreach ($colors as $color) {
                if (array_key_exists($color, $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"])) {
                    $colorsTitles[] = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"][$color];
                }
            }
            $where .= " AND (a.color='" . implode("' OR a.color='", $colorsTitles) . "')";
        }

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

        if ($priceFrom !== "" || $priceTo) {
            if ($priceFrom !== "") {
                if ($priceFrom === "0") {
                    $having .= "(current_bid_price IS NULL OR current_bid_price >=" . $priceFrom . ")";
                } else {
                    $having .= "(current_bid_price >=" . $priceFrom . ")";
                }
            }
            if ($priceTo) {
                if ($having) {
                    if ($priceFrom === "0") {
                        $having .= "AND (current_bid_price IS NULL OR current_bid_price <=" . $priceTo . ")";
                    } else {
                        $having .= "AND (current_bid_price <=" . $priceTo . ")";
                    }
                } else {
                    if ($priceFrom === "0") {
                        $having .= "(current_bid_price IS NULL OR current_bid_price <=" . $priceTo . ")";
                    } else {
                        $having .= "(current_bid_price <=" . $priceTo . ")";
                    }
                }
            }
        }

        if ($buyItNowOnly == 1) {
            if ($having) {
                $having .= "AND (current_bid_price IS NULL OR current_bid_price <= a.buy_now_price)";
            } else {
                $having .= "(current_bid_price IS NULL OR current_bid_price <= a.buy_now_price)";
            }
        }

        $latLon = null;
        if ($cityZip || $state) {
            $location = "";
            if ($cityZip) {
                $location .= $cityZip;
            }
            if ($state) {
                if ($cityZip) {
                    $location .= ", " . $state;
                } else {
                    $location .= $state;
                }
            }
            if ($location) {
                $location .= ", US";
            }
            $latLon = RecordsModel::getLatLon($location);
        }

        if ($milesRadius) {
            if ($latLon) {
                $milesRadius /= 1.60934;
                $where .= " AND (GetDistance(" . $latLon["lat"] . ", " . $latLon["lon"] . ", u.lat, u.lon)<=" . $milesRadius . ")";
            } else {
            }
        } else {
            if ($cityZip) {
                $where .= " AND (u.city = '" . $cityZip . "' OR u.zip='" . $cityZip . "')";
            }
            if ($state) {
                $where .= " AND (u.state = '" . $state . "')";
            }
        }

        if (!isset($where)) {
            $where = '1=1';
        }
        $countRecords = RecordsModel::getAuctionsCount($where, $having, $latLon);

        if (!empty($records)) {
            foreach ($records as $record) {
                $auctionSellerInfo = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array('USER_ID' => $record->user_id));
                if (is_object($auctionSellerInfo) && is_object($user)) {
                    $record->distance_from_buyer_to_seller = ($auctionSellerInfo->lat != "" && $auctionSellerInfo->lon != "" && $user->lat != "" && $user->lon != "") ? RecordsModel::getDistanceFromBuyerToSeller($user->lat, $user->lon, $auctionSellerInfo->lat, $auctionSellerInfo->lon, 3959) : "";
                }
            }
        }

        $filters = array(
            "make" => array(),
            "model" => array(),
            "price" => array(),
            "color" => array(),
            "year" => array(),
            "mileage" => array(),
        );
        $allRecords = RecordsModel::getAuctions($where, $having);
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
                    $filters["make"][$record->make] = array("name" => $record->make, "count" => 1, "selected" => ($record->make == $make ? 1 : 0));
                } elseif ($record->model) {
                    $filters["make"][$record->make]["count"]++;
                }
                if ($record->model && $record->make && !array_key_exists($record->model . "__" . $record->make, $filters["model"])) {
                    $filters["model"][$record->model . "__" . $record->make] = array("name" => $record->model, "make" => $record->make, "count" => 1, "selected" => ($model && $record->model == $model[0] && $record->make == $model[1] ? 1 : 0));
                } elseif ($record->model && $record->make) {
                    $filters["model"][$record->model . "__" . $record->make]["count"]++;
                }
                if ($record->color) {
                    $colorHex = (array_key_exists($record->color, $exteriorColors)) ? $exteriorColors[$record->color] : "#ffffff";
                    if (!array_key_exists($colorHex, $filters["color"])) {
                        $filters["color"][$colorHex] = array("name" => $record->color, "count" => 1, "selected" => (in_array($colorHex, $colors) ? 1 : 0));
                    } else {
                        $filters["color"][$colorHex]["count"]++;
                    }
                }
                $auctionSellerInfo = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array('USER_ID' => $record->user_id));
                if (is_object($auctionSellerInfo) && is_object($user)) {
                    $record->distance_from_buyer_to_seller = (isset($auctionSellerInfo->lat) && $auctionSellerInfo->lat != "" && isset($auctionSellerInfo->lon) && $auctionSellerInfo->lon != "" && isset($user->lat) && $user->lat != "" && $user->lon != "" && isset($user->lon)) ? RecordsModel::getDistanceFromBuyerToSeller($user->lat, $user->lon, $auctionSellerInfo->lat, $auctionSellerInfo->lon, 3959) : "";
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

        if ($this->isAjax()) {
            $limit = 25;
            if ($action == "load_more") {
                $manager = new stdClass;
                $manager->total = $countRecords;
                $manager->limit = $limit;
                $manager->total_pages = ceil($manager->total / $manager->limit);
                $manager->page = isset($_REQUEST['page']) && $_REQUEST['page'] > 1 ? intval($_REQUEST['page']) : 1;
                $manager->offset = $manager->limit * ($manager->page - 1);
                $limit = $manager->offset . ", " . $manager->limit;
                $records = $countRecords ? RecordsModel::getAuctions($where, $having, $limit, $order, $latLon) : null;
                $data = array('has_more' => $manager->page < $manager->total_pages);
                if ($records) {
                    $data['html'] = $this->fetchTemplate("auctions_list.tpl", array(
                        "manager" => $manager,
                        "records" => $records,
                        "user_favs" => $userFavs,
                        "user" => isset($user) ? $user : null
                    ));
                }
                $data["count_records"] = $countRecords;
                $data["where_val"] = $manager->page;
                exit(json_encode($data));
                return true;
            } else {
                $records = $countRecords ? RecordsModel::getAuctions($where, $having, $limit, $order, $latLon) : null;

                $data = array();
                $data["html"] = $this->fetchTemplate("auctions_list.tpl", array(
                    "records" => $records,
                    "user_favs" => $userFavs,
                    "user" => isset($user) ? $user : null
                ));
                $data["count_records"] = $countRecords;
                $data["filters"] = $filters;
                $data["keyword_title"] = $keyword ? "Search Results for <span>" . $keyword . "</span>" : "All Auctions";
                echo json_encode($data);
                return true;
            }
        }
//        $countRecords = RecordsModel::getNewsCount($where);
        $records = $countRecords ? RecordsModel::getAuctions($where, $having, $sqlLimit, $order, $latLon) : null;
        $countPages = 0;
        if ($page == 1) {
            $countPages = ceil(($countRecords - 1) / ($limit - 1));
        } else {
            $countPages = ceil($countRecords / $limit);
        }
        $flag_discount = 2;
        if($user->discount_code != ''){

          $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $user->discount_code,'STATUS' => 1));
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
            if($records){
              foreach ($records as $key => &$value) {
                  $value->this_price = $value->buy_now_price;
                  $value->buy_now_price = floatval($value->buy_now_price) - (floatval($value->buy_now_price) * intval($code->percent)/100);
              }
            }

          }else{
            foreach ($records as $key => &$value) {
                $value->this_price = $value->buy_now_price;
                $value->buy_now_price = floatval($value->buy_now_price) - intval($code->price);
            }
          }


        }
        return $this->displayTemplate("auctions.tpl", array(
            "flag_discount" => $flag_discount,
            "records" => $records,
            "count_records" => $countRecords,
            "filters" => $filters,
            "exterior_colors" => $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"],
            "user_favs" => $userFavs,
            "user" => isset($user) ? $user : null,
            "page" => $page,
            "count_pages" => $countPages
        ));
    }

}

?>

<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/common_records_model.php");

class RecordsModel extends CommonRecordsModel
{
    public static function getNewsCount($where = "")
    {
        $sql = "SELECT COUNT(b.id) AS count";
        $sql .= " FROM blog_posts b";
        $sql .= " LEFT JOIN blog_categories bc ON(b.category_id = bc.id)";
        $sql .= " LEFT JOIN users u ON(b.author_id = u.id)";
        $sql .= " WHERE b.status = 1 AND b.approved = 1 " . ($where ? "AND " . $where : "");
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record ? $record->count : 0;
    }

    public static function getNextBuyer($auction_id = "")
    {
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auction_id . " ORDER BY bid_price DESC LIMIT 1, 1";
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record;
    }

    public static function getFirstBuyer($auction_id = "")
    {
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auction_id . " ORDER BY bid_price DESC";
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record;
    }

    public static function getNextBuyerMaximum($auction_id = "", $user_id)
    {
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auction_id . " AND user_id != ".$user_id." ORDER BY maximum_proxy DESC";
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record;
    }

    public static function getFirstBuyerMaximum($auction_id = "")
    {
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auction_id . " AND winning_bid = 1 ORDER BY maximum_proxy DESC, id ASC";
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record;
    }

    static function autoUpdateStatusAuction($user_id = false){
        if ($user_id) {
            $sql = "UPDATE `auctions` SET `auction_status`='Canceled' WHERE `user_id` = ".$user_id." AND `auction_status` = 'Active' AND expiration_date < now()";
        } else {
            $sql = "UPDATE `auctions` SET `auction_status`='Canceled' WHERE `auction_status` = 'Active' AND expiration_date < now()";
        }
        FJF_BASE_RICH::executeQuery($sql);
        return true;
    }

    static function autoUpdateCountViewAuction($auction_id, $count_view){

        $sql = "UPDATE `auctions` SET `count_view`= ".$count_view." WHERE `id` = ".$auction_id;
        FJF_BASE_RICH::executeQuery($sql);
        return true;
    }

    public static function getWinning($auction_id = "")
    {
        $sql = "SELECT *";
        $sql .= " FROM auctions_bids";
        $sql .= " WHERE auction_id = " . $auction_id . " AND winning_bid = 1 ORDER BY id DESC";
        $record = FJF_BASE_RICH::selectRecords($sql, null, true);
        return $record;
    }

    public static function resetWinningAuctionsBids($auction_id = "")
    {
//        FJF_BASE::db_update('auctions_bids', ['winning_bid = 0'], 'auction_id = ' . $auction_id);
        return true;
    }

    public static function getNews($where = "", $limit = null, $order = null)
    {
        $sql = "SELECT b.id, u.name AS author, u.url_title AS author_url_title, bc.title AS category, bc.url_title AS category_url_title, b.title, b.image, b.category_id, b.author_id, b.description, b.datetime_publish, b.url_title, b.meta_title, b.meta_keywords, b.meta_description";
        $sql .= " FROM blog_posts b";
        $sql .= " LEFT JOIN blog_categories bc ON(b.category_id = bc.id)";
        $sql .= " LEFT JOIN users u ON(b.author_id = u.id)";
        $sql .= " WHERE b.status = 1 AND b.approved = 1 " . ($where ? "AND " . $where : "");
        $sql .= " ORDER BY " . ($order ? $order : " datetime_publish DESC");
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }
        $records = FJF_BASE_RICH::selectRecords($sql);
        return $records;
    }

    static function deleteRecord($table, $id){
        $sql = "DELETE FROM ". $table ." WHERE id = " . $id;
        FJF_BASE_RICH::executeQuery($sql);
//        FJF_BASE_RICH::executeQuery
        return true;
    }

    public static function getNew($urlTitle = "")
    {
        $where = "b.url_title = '" . $urlTitle . "'";
        $record = RecordsModel::getNews($where, 1);
        $record = $record ? $record[0] : null;
        return $record;
    }

    static function updateWinner($auction_id, $user_id){
        $sql = "UPDATE `auctions` SET `winner_id`=".$user_id." WHERE `id` = ".$auction_id;
        FJF_BASE_RICH::executeQuery($sql);
        return true;
    }

    public static function getAuctionsCount($where = "", $having = "", $latLon = null)
    {
        $sql = "SELECT a.id, a.buy_now_price";
        if ($latLon && array_key_exists("lon", $latLon) && array_key_exists("lat", $latLon)) {
            $sql .= ", GetDistance(" . $latLon["lat"] . ", " . $latLon["lon"] . ", u.lat, u.lon) * 1.60934 AS distance";
        } else {
            $sql .= ", '' AS distance";
        }
        $sql .= ", (SELECT (CASE WHEN MAX(ab.bid_price) IS NOT NULL THEN MAX(ab.bid_price) ELSE 0 END) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS current_bid_price";
        $sql .= ", (SELECT COUNT(ab.id) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS count_bids";
        $sql .= " FROM auctions a";
        $sql .= " LEFT JOIN users u ON(a.user_id = u.id)";
        $sql .= " WHERE a.status = 1 AND a.approved = 1 " . ($where ? " AND " . $where : ""); // a.expiration_date IS NULL OR a.expiration_date = ''
        if ($having) {
            $sql .= " HAVING " . $having;
        }
        $sql .= " ORDER BY expiration_date";
        $record = FJF_BASE_RICH::selectRecords($sql, null);
        return $record ? count($record) : 0;
    }

    public static function getAuctions($where = "", $having = "", $limit = null, $order = null, $latLon = null)
    {
        $sql = "SELECT a.id, a.title, a.vin_number, a.make, a.model, a.year, a.mileage, a.photos, a.expiration_date, a.user_id, a.color, u.state, u.city, a.auction_status, a.auction_completion_date, a.sell_to, a.buy_now_price, a.datetime_create, a.starting_bid_price";
        if ($latLon && array_key_exists("lon", $latLon) && array_key_exists("lat", $latLon)) {
            $sql .= ", GetDistance(" . $latLon["lat"] . ", " . $latLon["lon"] . ", u.lat, u.lon) * 1.60934 AS distance";
        } else {
            $sql .= ", '' AS distance";
        }
        $sql .= ", (SELECT (CASE WHEN MAX(ab.bid_price) IS NOT NULL THEN MAX(ab.bid_price) ELSE 0 END) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS current_bid_price";
        $sql .= ", (SELECT COUNT(ab.id) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS count_bids";
        $sql .= " FROM auctions a";
        $sql .= " LEFT JOIN users u ON(a.user_id = u.id)";
        $sql .= " WHERE  a.status = 1 AND a.approved = 1 " . ($where ? " AND " . $where : ""); // a.expiration_date IS NULL OR a.expiration_date = ''
        if ($having) {
            $sql .= " HAVING " . $having;
        }
        $sql .= " ORDER BY " . ($order ? $order : "a.datetime_create DESC");
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }
        $records = FJF_BASE_RICH::selectRecords($sql);
        if ($records) {
            foreach ($records as $key => $record) {
                $records[$key]->count_down = null;
                $records[$key]->count_down_red = null;
                $records[$key]->expiration_date_main = null;
                if ($record->expiration_date) {
                    $records[$key]->expiration_date_main = strtotime($record->expiration_date) - time();
                    if (strtotime($record->expiration_date) - time() < 60 * 60 * 24) {
                        $records[$key]->count_down = strtotime($record->expiration_date) - time();
                        if (strtotime($record->expiration_date) - time() < 60 * 60) {
                            $records[$key]->count_down_red = 1;
                        }
                    }
                }
                $records[$key]->image = "";
                if ($record->photos) {
                    $record->photos = json_decode($record->photos);
                    if (isset($record->photos[0]->photo)) {
                        $records[$key]->image = $record->photos[0]->photo;
                    }
                }
            }
        }
        return $records;
    }

    public static function getAllAuctionsCount($where = "", $having = "", $latLon = null)
    {
        $sql = "SELECT a.id";
        if ($latLon && array_key_exists("lon", $latLon) && array_key_exists("lat", $latLon)) {
            $sql .= ", GetDistance(" . $latLon["lat"] . ", " . $latLon["lon"] . ", u.lat, u.lon) * 1.60934 AS distance";
        } else {
            $sql .= ", '' AS distance";
        }
        $sql .= ", (SELECT (CASE WHEN MAX(ab.bid_price) IS NOT NULL THEN MAX(ab.bid_price) ELSE 0 END) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS current_bid_price";
        $sql .= ", (SELECT COUNT(ab.id) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS count_bids";
        $sql .= " FROM auctions a";
        $sql .= " LEFT JOIN users u ON(a.user_id = u.id)";
        $sql .= " WHERE a.status = 1 AND a.approved = 1 " . ($where ? "AND " . $where : "");
        if ($having) {
            $sql .= " HAVING " . $having;
        }
        $sql .= " ORDER BY expiration_date";
        $record = FJF_BASE_RICH::selectRecords($sql, null);
        return $record ? count($record) : 0;
    }

    public static function getAllAuctions($where = "", $having = "", $limit = null, $order = null, $latLon = null)
    {
        $sql = "SELECT a.id, a.title, a.vin_number, a.make, a.model, a.year, a.mileage, a.photos, a.expiration_date, a.user_id, a.color, u.state, u.city, a.auction_status, a.auction_completion_date, a.engine, a.number_of_cylinders, a.number_of_doors, a.trim, a.trim2, a.fuel_type, a.options, a.mpg, a.description, a.additional_fees, a.title_wait_time, a.terms_conditions, a.title_status, a.auction_condition, a.transmission, a.buy_now_price, a.starting_bid_price, a.reserve_price, a.sell_to, a.terms_condition_id, a.additional_fees, a.payment_pickup_id, a.sell_to, a.additional_fees_id, a.drive_type, a.interior_color, a.payment_method, a.pickup_window, a.pickup_note, a.datetime_update, a.buy_now_price, a.auctions_length, a.datetime_create, a.winner_id, a.count_view";
        if ($latLon && array_key_exists("lon", $latLon) && array_key_exists("lat", $latLon)) {
            $sql .= ", GetDistance(" . $latLon["lat"] . ", " . $latLon["lon"] . ", u.lat, u.lon) * 1.60934 AS distance";
        } else {
            $sql .= ", '' AS distance";
        }
        $sql .= ", (SELECT MAX(ab.bid_price) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS current_bid_price";
        $sql .= ", (SELECT ab.user_id FROM auctions_bids ab WHERE ab.auction_id = a.id AND ab.winning_bid = 1 LIMIT 1) AS winning_user_id";
        $sql .= ", (SELECT COUNT(ab.id) FROM auctions_bids ab WHERE ab.auction_id = a.id) AS count_bids";
        $sql .= " FROM auctions a";
        $sql .= " LEFT JOIN users u ON(a.user_id = u.id)";
        $sql .= " WHERE  a.status = 1 AND a.approved = 1 " . ($where ? "AND " . $where : "");
        if ($having) {
            $sql .= " HAVING " . $having;
        }
        //$sql .= " ORDER BY " . ($order ? $order : " expiration_date");
        $sql .= " ORDER BY " . ($order ? $order : " IF(auction_status = 'Active', 5, 0) DESC, IF(auction_status = 'Sold', 4, 0) DESC, datetime_create DESC");
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }

        $records = FJF_BASE_RICH::selectRecords($sql);
        if ($records) {
            foreach ($records as $key => $record) {
                $records[$key]->count_down = null;
                $records[$key]->count_down_red = null;
                $records[$key]->expiration_date_main = null;
                if ($record->expiration_date) {
                    $records[$key]->expiration_date_main = strtotime($record->expiration_date) - time();
                    if (strtotime($record->expiration_date) - time() < 60 * 60 * 24) {
                        $records[$key]->count_down = strtotime($record->expiration_date) - time();
                        if (strtotime($record->expiration_date) - time() < 60 * 60) {
                            $records[$key]->count_down_red = 1;
                        }
                    }
                }
                $records[$key]->image = "";
                if ($record->photos) {
                    $record->photos = json_decode($record->photos);
                    if (isset($record->photos[0]->photo)) {
                        $records[$key]->image = $record->photos[0]->photo;
                    }
                }
            }
        }
        return $records;
    }

    public static function getSellerAuctionsStatuses($where = "")
    {
        $sql = "SELECT a.id, a.auction_status";
        $sql .= " FROM auctions a";
        $sql .= " WHERE  a.status = 1 AND a.approved = 1 " . ($where ? "AND " . $where : "");
        $records = FJF_BASE_RICH::selectRecords($sql);
        return $records;
    }

    public static function getAuctionBidsCount($auctionID = 0)
    {
        $sql = "SELECT COUNT(ab.id) AS cnt FROM auctions_bids ab WHERE ab.auction_id = AUCTION_ID";
        $record = FJF_BASE_RICH::selectRecords($sql, array("AUCTION_ID" => $auctionID), true);
        return (is_object($record) && $record->cnt > 0) ? $record->cnt : 0;
    }

    public static function getAuctionMaxBidPrice($auctionID = 0)
    {
        $sql = "SELECT MAX(ab.bid_price) AS bid_price FROM auctions_bids ab WHERE ab.auction_id = AUCTION_ID";
        $record = FJF_BASE_RICH::selectRecords($sql, array("AUCTION_ID" => $auctionID), true);
        return (is_object($record) && $record->bid_price > 0) ? floatval($record->bid_price) : 0;
    }

    public static function getLatLon($string)
    {
        $string = str_replace(" ", "+", urlencode($string));
        $detailsUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $string . "&sensor=false&key=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["google_map_api_key"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $detailsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        if ($response['status'] != 'OK') {
            return null;
        }
        $geometry = $response['results'][0]['geometry'];
        $data = array(
            'lon' => $geometry['location']['lng'],
            'lat' => $geometry['location']['lat']
        );
        return $data;
    }

    public static function getDistanceFromBuyerToSeller($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = "")
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public static function getClientIp()
    {
        $ip = null;
        if (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    public static function getLatLonByIP()
    {
        $data = array('lon' => null, 'lat' => null);
        $clientIP = self::getClientIp();
        if ($clientIP != '') {
            $ch = curl_init('http://api.ipstack.com/' . $clientIP . '?access_key=5a1911382907fc0262596c367c93118d&output=json&fields=latitude,longitude');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (!empty($response) && array_key_exists('latitude', $response) && array_key_exists('longitude', $response)) {
                $data = array(
                    'lon' => $response['longitude'],
                    'lat' => $response['latitude']
                );
            }
        }
        return $data;
    }

    public static function getCarInfoByVIN($vin = "")
    {
        if ($vin != "") {
            $apiURL = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVinValuesExtended/" . $vin . "?format=json";
            $curl = curl_init($apiURL);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($curl), true);
            curl_close($curl);
            return (is_array($response) && array_key_exists("Results", $response)) ? $response["Results"][0] : null;
        }
        return null;
    }

    public static function getBuyerBids($buyerID = 0)
    {
        $sql = "SELECT ab.auction_id, ab.datetime_create, ab.bid_price, a.id, a.make, a.model, a.year, a.photos";
        $sql .= " FROM auctions_bids ab";
        $sql .= " LEFT JOIN auctions a ON ab.auction_id = a.id";
        $sql .= " WHERE ab.user_id = 'USER_ID'";
        $sql .= " AND a.status = 1 AND a.approved = 1 AND a.auction_status = 'Active' AND a.expiration_date > NOW()";
        $sql .= " GROUP BY (ab.auction_id) ORDER BY ab.datetime_create DESC ,a.expiration_date ASC ";
        $currentAuctions = FJF_BASE_RICH::selectRecords($sql, array('USER_ID' => $buyerID));
        if (!empty($currentAuctions)) {
            foreach ($currentAuctions as $currentAuction) {
                $currentAuction->auction_image = "";
                if ($currentAuction->photos != "") {
                    $photos = json_decode($currentAuction->photos);
                    if (isset($photos[0]->photo)) $currentAuction->auction_image = $photos[0]->photo;
                }
            }
        }

        $sql = "SELECT ab.auction_id, ab.datetime_create, ab.bid_price, a.id, a.make, a.model, a.year, a.photos";
        $sql .= " FROM auctions_bids ab";
        $sql .= " LEFT JOIN auctions a ON ab.auction_id = a.id";
        $sql .= " WHERE ab.user_id = 'USER_ID'";
        $sql .= " AND a.auction_status <> 'Active' AND a.expiration_date < NOW()";
        $sql .= " GROUP BY (ab.auction_id) ORDER BY ab.datetime_create DESC,a.expiration_date DESC";
        $pastAuctions = FJF_BASE_RICH::selectRecords($sql, array('USER_ID' => $buyerID));
        if (!empty($pastAuctions)) {
            foreach ($pastAuctions as $pastAuction) {
                $pastAuction->auction_image = "";
                if ($pastAuction->photos != "") {
                    $photos = json_decode($pastAuction->photos);
                    if (isset($photos[0]->photo)) $pastAuction->auction_image = $photos[0]->photo;
                }
            }
        }
        return array("current" => $currentAuctions, "past" => $pastAuctions);
    }

    public static function getCityStateByZip($zip)
    {
        $detailsUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $zip . "&sensor=false&key=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["google_map_api_key"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $detailsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        if ($response["status"] != "OK") {
            return null;
        }

        $components = $response["results"][0]["address_components"];
        $cityInfo = self::filterGeocodeState($components, "locality");
        $city = (!empty($cityInfo)) ? array_values($cityInfo)[0]["short_name"] : "";
        $stateInfo = self::filterGeocodeState($components, "administrative_area_level_1");
        $state = (!empty($stateInfo)) ? array_values($stateInfo)[0]["short_name"] : "";

        $data = array(
            "lon" => $response["results"][0]["geometry"]["location"]["lng"],
            "lat" => $response["results"][0]["geometry"]["location"]["lat"],
            "city" => $city,
            "state" => $state
        );

        return $data;
    }

    static function getTimeZone($string)
    {
        //$string = str_replace (" ", "+", urlencode($string));
        $details_url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $string . "&timestamp=" . time() . "&key=AIzaSyBik7Bj4iwephBDANkUvSjRPaQiHhrfnvs";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        if ($response['status'] != 'OK') {
            return null;
        }
        return $response["timeZoneId"];
    }

    static function filterGeocodeState($components, $type)
    {
        return array_filter($components, function ($component) use ($type) {
            return array_filter($component["types"], function ($data) use ($type) {
                return $data == $type;
            });
        });
    }

    static function filterGeocodeCity($components, $type)
    {
        return array_filter($components, function ($component) use ($type) {
            return array_filter($component["types"], function ($data) use ($type) {
                return $data == $type;
            });
        });
    }

}

?>

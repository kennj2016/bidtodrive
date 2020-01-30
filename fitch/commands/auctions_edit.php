<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/notification_model.php");

class AuctionsEdit extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;
    var $notificationModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        $this->notificationModel = new NotificationModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $hasError = false;
        $status = "";

        $hasLicenseError = false;
        $licenseStatus = "";

        $userID = SessionModel::loggedUserID();
        $userType = SessionModel::getUserType();
        $user = FJF_BASE_RICH::getRecordBy("users", $userID);

        if ($userType != "Seller") {
            FJF_BASE::redirect("/account/buyer/");
        }

        if ($user->license_expired == 1) {
            $hasLicenseError = true;
            $licenseStatus = "Your license is expired. Please renew your license and update your account to continue.";
        }

        $action = isset($_REQUEST["action"]) ? trim($_REQUEST["action"]) : "";
        $recordID = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;

        $defaultTermsConditions = FJF_BASE_RICH::getRecord("site_vars", "name = 'default_terms_conditions'");
        $defaultAdditionalFees = FJF_BASE_RICH::getRecord("site_vars", "name = 'default_additional_fees'");

        $activeAuctions = FJF_BASE_RICH::getRecords("auctions", "auction_status='Active' AND status=1 AND approved=1 AND expiration_date > NOW()", null, false, "id, vin_number");
        $vinsArr = array();
        if(!empty($activeAuctions)){
            foreach($activeAuctions as $activeAuction){
                $vinsArr[] = $activeAuction->vin_number;
            }
        }

        $states = FJF_BASE_RICH::getRecords("states");
        $contentBlocks = array("terms" => null, "fees" => null);
        $userContentBlocks = FJF_BASE_RICH::getRecords("auctions_content_blocks", "user_id=USER_ID AND status=1 AND approved=1 ORDER BY position DESC", array("USER_ID" => $userID));
        if (!empty($userContentBlocks)) {
            foreach ($userContentBlocks as $userContentBlock) {
                if ($userContentBlock->type == "Terms & Conditions") {
                    $contentBlocks["terms"][$userContentBlock->id] = $userContentBlock;
                } elseif ($userContentBlock->type == "Additional Fees") {
                    $contentBlocks["fees"][$userContentBlock->id] = $userContentBlock;
                } elseif ($userContentBlock->type == "Payment/Pickup") {
                    $contentBlocks["payment_pickup"][$userContentBlock->id] = $userContentBlock;
                }
            }
        }
        $paymentPickupContentBlocks = FJF_BASE_RICH::getRecords("auctions_content_blocks", "status=1 AND approved=1 AND type='Payment/Pickup' AND user_id = 'USER_ID'", array('USER_ID' => $userID));

        if ($action == "create") {
            $editorParams = array(
                "table" => "auctions",
                "title_field" => "title",
                "positions" => true
            );
            $editor = new AdminEditRevisionsModel($editorParams);
            $record = $editor->loadRecord();
        } elseif ($action == "edit") {
            $editorParams = array(
                "id" => $recordID,
                "table" => "auctions",
                "title_field" => "title",
                "positions" => true
            );
            $editor = new AdminEditRevisionsModel($editorParams);
            $record = $editor->loadRecord();
            $bidsCount = RecordsModel::getAuctionBidsCount($recordID);

            if (empty($record)) {
                $hasError = true;
                $status = "Auction not found.";
            } elseif ($record->user_id !== $userID) {
                $hasError = true;
                $status = "Editing is disabled. You're not the auction owner.";
            } elseif ($bidsCount > 0) {
                $hasError = true;
                $status = "The auction has bids already. Editing is disabled.";
            }
            if (isset($record->photos)) {
                $record->photos = ($record->photos != "") ? json_decode($record->photos) : array();
            }
        } elseif ($action == "relist") {
            $editorParams = array(
                "id" => $recordID,
                "table" => "auctions",
                "title_field" => "title",
                "positions" => true
            );
            $editor = new AdminEditRevisionsModel($editorParams);
            $record = $editor->loadRecord();
            if (empty($record)) {
                $record = FJF_BASE_RICH::getRecord("auctions", "id = ".$recordID." limit 1", array());
                // $hasError = true;
                // $status = "There is no other auction currently active with that VIN";
            }
            if (empty($record)) {
                $hasError = true;
                $status = "There is no other auction currently active with that VIN";
            } elseif ($record->user_id !== $userID) {
                $hasError = true;
                $status = "Editing is disabled. You're not the auction owner.";
            } elseif ($record->disallow_accept_highest_bid == 1 || $record->auction_status == "Sold") {
                $hasError = true;
                $status = "Relisting is disabled.";
            }
            if(!empty($record) && isset($record->photos) && $record->photos != ""){
                $record->photos = json_decode($record->photos);
            }
        }

        if (!$hasError) {
            if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
                $step = isset($_POST["step"]) ? intval($_POST["step"]) : 0;
                if ($step == 1) {
                    $fields["reserve_price"] = (isset($_POST["reserve_price"])) ? FJF_BASE::moneyUnformat($_POST["reserve_price"]) : "";
                    $fields["starting_bid_price"] = (isset($_POST["starting_bid_price"])) && $_POST["starting_bid_price"] != "" ? FJF_BASE::moneyUnformat($_POST["starting_bid_price"]) : "";
                    $fields["buy_now_price"] = (isset($_POST["buy_now_price"])) ? FJF_BASE::moneyUnformat($_POST["buy_now_price"]) : "";
                    $fields["auctions_length"] = (isset($_POST["auctions_length"])) ? intval($_POST["auctions_length"]) : 0;
                    $fields["vin_number"] = (isset($_POST["vin_number"])) ? trim($_POST["vin_number"]) : "";

                    if (!$fields["auctions_length"]) {
                        $hasError = true;
                        $status .= "'Auction Length' is missing.<br/>";
                    } elseif (!is_numeric($fields["auctions_length"])) {
                        $hasError = true;
                        $status .= "Enter a valid 'Auction Length'.<br/>";
                    }

                    if ($fields["starting_bid_price"] === "") {
                        $hasError = true;
                        $status .= "'Starting Bid Price' is missing.<br/>";
                    } elseif (!is_numeric($fields["starting_bid_price"])) {
                        $hasError = true;
                        $status .= "Enter a valid 'Starting Bid Price'.<br/>";
                    }

                    if ($fields["reserve_price"] != "" && ($fields["reserve_price"] <= $fields["starting_bid_price"])) {
                        $hasError = true;
                        $status .= "'Reserve Price' must be higher than 'Starting Bid Price'.<br/>";
                    }

                    if ($fields["buy_now_price"]  < $fields["starting_bid_price"]) {
                        $hasError = true;
                        $status .= "'Buy Now Price' must be higher than or equal 'Starting Bid Price'.<br/>";
                    }

                    if ($_POST["reserve_price"] != "" && $fields["reserve_price"] == 0) {
                        $hasError = true;
                        $status .= "Enter a valid 'Reserve Price'.<br/>";
                    }

                    if ($_POST["buy_now_price"] != "" && $fields["buy_now_price"] == 0) {
                        $hasError = true;
                        $status .= "Enter a valid 'Buy Now Price'.<br/>";
                    }

                    if (!$fields["vin_number"]) {
                        $hasError = true;
                        $status .= "'Vin Number' is missing.<br/>";
                    }

                    if (in_array($fields["vin_number"], $vinsArr) && $action != "edit") {
                        $hasError = true;
                        $status .= "Active auction with the same 'VIN Number' already exists.<br/>";
                    }

                    $output["car_info"] = null;
                    if (!$hasError) {
                        $carInfo = RecordsModel::getCarInfoByVIN($fields["vin_number"]);
                        $carInfo["Make"] = FJF_BASE::ucname($carInfo["Make"]);
                        $output["car_info"] = (!empty($carInfo)) ? $carInfo : null;

                        $fields["reserve_price_formatted"] = FJF_BASE::moneyFormat($fields["reserve_price"]);
                        $fields["starting_bid_price_formatted"] = FJF_BASE::moneyFormat($fields["starting_bid_price"]);
                        $fields["buy_now_price_formatted"] = FJF_BASE::moneyFormat($fields["buy_now_price"]);

                        $_SESSION["auction_info"] = $fields;
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;

                } elseif ($step == 2) {
                    if ($action == "create") {
                        $fields["make"] = (isset($_POST["s2_make"])) ? trim($_POST["s2_make"]) : "";
                        $fields["model"] = (isset($_POST["s2_model"])) ? trim($_POST["s2_model"]) : "";
                        $fields["year"] = (isset($_POST["s2_year"])) ? intval($_POST["s2_year"]) : 0;
                        $fields["engine"] = (isset($_POST["s2_engine"])) ? trim($_POST["s2_engine"]) : "";
                        $fields["number_of_cylinders"] = (isset($_POST["s2_number_of_cylinders"])) ? intval($_POST["s2_number_of_cylinders"]) : 0;
                        $fields["number_of_doors"] = (isset($_POST["s2_number_of_doors"])) ? intval($_POST["s2_number_of_doors"]) : 0;
                        $fields["trim"] = (isset($_POST["s2_trim"])) ? trim($_POST["s2_trim"]) : "";
                        $fields["trim2"] = (isset($_POST["s2_trim2"])) ? trim($_POST["s2_trim2"]) : "";
                    } else {
                        $fields["make"] = $record->make;
                        $fields["model"] = $record->model;
                        $fields["year"] = $record->year;
                        $fields["engine"] = $record->engine;
                        $fields["number_of_cylinders"] = $record->number_of_cylinders;
                        $fields["number_of_doors"] = $record->number_of_doors;
                        $fields["trim"] = $record->trim;
                        $fields["trim2"] = $record->trim2;
                    }

                    if (!$hasError) {
                        $_SESSION["auction_info"] = array_merge($_SESSION["auction_info"], $fields);
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;

                } elseif ($step == 3) {

                    $fields["color"] = (isset($_POST["s3_color"])) ? trim($_POST["s3_color"]) : "";
                    $fields["interior_color"] = (isset($_POST["s3_interior_color"])) ? trim($_POST["s3_interior_color"]) : "";
                    $fields["auction_condition"] = (isset($_POST["s3_auction_condition"])) ? trim($_POST["s3_auction_condition"]) : "";
                    $fields["mileage"] = (isset($_POST["s3_mileage"])) ? FJF_BASE::moneyUnformat($_POST["s3_mileage"]) : 0;
                    $fields["title_status"] = (isset($_POST["s3_title_status"])) ? trim($_POST["s3_title_status"]) : "";
                    $fields["title_wait_time"] = (isset($_POST["s3_title_wait_time"])) ? trim($_POST["s3_title_wait_time"]) : "";
                    $fields["transmission"] = (isset($_POST["s3_transmission"])) ? trim($_POST["s3_transmission"]) : "";
                    $fields["sell_to"] = (isset($_POST["s3_sell_to"]) && intval($_POST["s3_sell_to"]) > 0) ? intval($_POST["s3_sell_to"]) : 2;
                    $fields["drive_type"] = (isset($_POST["s3_drive_type"])) ? trim($_POST["s3_drive_type"]) : "";
                    $fields["description"] = (isset($_POST["s3_desciption"])) ? trim($_POST["s3_desciption"]) : "";
                    $fields["fuel_type"] = (isset($_POST["s3_fuel_type"])) ? trim($_POST["s3_fuel_type"]) : "";

                    if (!$fields["mileage"]) {
                        $hasError = true;
                        $status .= "'Mileage' is missing.<br/>";
                    } elseif (!is_numeric($fields["mileage"])) {
                        $hasError = true;
                        $status .= "Enter a valid 'Mileage'.<br/>";
                    }

                    if (!$hasError) {

                        $fields["mileage_formatted"] = FJF_BASE::moneyFormat($fields["mileage"]);

                        $_SESSION["auction_info"] = array_merge($_SESSION["auction_info"], $fields);
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;

                } elseif ($step == 4) {
                    $fields["terms_condition_id"] = (isset($_POST["s4_terms_condition_id"])) ? intval($_POST["s4_terms_condition_id"]) : 0;
                    $fields["terms_condition"] = (isset($_POST["s4_terms_condition"])) ? trim($_POST["s4_terms_condition"]) : "";
                    $fields["additional_fees_id"] = (isset($_POST["s4_additional_fees_id"])) ? intval($_POST["s4_additional_fees_id"]) : 0;
                    $fields["additional_fees"] = (isset($_POST["s4_additional_fees"])) ? trim($_POST["s4_additional_fees"]) : "";
                    $fields["payment_pickup_id"] = (isset($_POST["s4_payment_pickup_id"])) ? intval($_POST["s4_payment_pickup_id"]) : 0;
                    $fields["payment_method"] = (isset($_POST["s4_payment_method"])) ? $_POST["s4_payment_method"] : array();
                    $fields["pickup_window"] = (isset($_POST["s4_pickup_window"])) ? intval($_POST["s4_pickup_window"]) : 0;
                    $fields["pickup_note"] = (isset($_POST["s4_pickup_note"])) ? trim($_POST["s4_pickup_note"]) : "";
                    $fields["payment_pickup"] = "";
                    $ppID = FJF_BASE_RICH::getRecord("auctions_content_blocks", "id = 'PP_ID'", array("PP_ID" => $fields["payment_pickup_id"]));

                    if (is_object($ppID)) {
                        $fields["payment_pickup"] = $ppID->title;
                    }

                    if (!$hasError) {
                        if ($fields["terms_condition"] != "") {
                            $output["auction_info"]["terms_condition"] = $fields["terms_condition"] = $fields["terms_condition"];
                        } else {
                            if ($fields["terms_condition_id"] == 0) {
                                $output["auction_info"]["terms_condition"] = $defaultTermsConditions->value;
                                $fields["terms_condition"] = $defaultTermsConditions->value;
                            } elseif (array_key_exists($fields["terms_condition_id"], $contentBlocks["terms"])) {
                                $output["auction_info"]["terms_condition"] = $contentBlocks["terms"][$fields["terms_condition_id"]]->description;
                                $fields["terms_condition"] = $contentBlocks["terms"][$fields["terms_condition_id"]]->description;
                            }
                        }

                        if ($fields["additional_fees"] != "") {
                            $output["auction_info"]["additional_fees"] = $fields["additional_fees"] = $fields["additional_fees"];
                        } else {
                            if ($fields["additional_fees_id"] == 0) {
                                $output["auction_info"]["additional_fees"] = $defaultAdditionalFees->value;
                                $fields["additional_fees"] = $defaultAdditionalFees->value;
                            } elseif (array_key_exists($fields["additional_fees_id"], $contentBlocks["fees"])) {
                                $output["auction_info"]["additional_fees"] = $contentBlocks["fees"][$fields["additional_fees_id"]]->description;
                                $fields["additional_fees"] = $contentBlocks["fees"][$fields["additional_fees_id"]]->description;
                            }
                        }

                        if (!empty($fields["payment_method"]) || $fields["pickup_window"] != 0 || $fields["pickup_note"] != "") {
                            $output["auction_info"]["payment_method"] = $fields["payment_method"];
                            $output["auction_info"]["pickup_window"] = $fields["pickup_window"];
                            $output["auction_info"]["pickup_note"] = $fields["pickup_note"];
                            $fields["payment_pickup_id"] = 0;
                        } elseif ($fields["payment_pickup_id"] > 0) {
                            $output["auction_info"]["payment_method"] = $fields["payment_method"] = $contentBlocks["payment_pickup"][$fields["payment_pickup_id"]]->payment_method;
                            $output["auction_info"]["pickup_window"] = $fields["pickup_window"] = $contentBlocks["payment_pickup"][$fields["payment_pickup_id"]]->pickup_window;
                            $output["auction_info"]["pickup_note"] = $fields["pickup_note"] = $contentBlocks["payment_pickup"][$fields["payment_pickup_id"]]->pickup_note;
                        } else {
                            $output["auction_info"]["payment_method"] = $fields["payment_method"] = "";
                            $output["auction_info"]["pickup_window"] = $fields["pickup_window"] = 0;
                            $output["auction_info"]["pickup_note"] = $fields["pickup_note"] = "";
                        }
                        $_SESSION["auction_info"] = array_merge($_SESSION["auction_info"], $fields);
                        $output["auction_info"] = $_SESSION["auction_info"];
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;

                } elseif ($step == 5) {
                    $photos = (isset($_POST["photos"]) && is_array($_POST["photos"]) && !empty($_POST["photos"])) ? $_POST["photos"] : null;
                    if (!empty($photos)) {
                        $fields["photos"] = "";
                        $photosArr = array();
                        foreach ($photos as $photoID => $photo) {
                            $photosArr[] = array("photo" => $photoID, "title" => $photo);
                        }
                        $fields["photos"] = json_encode($photosArr);
                    }else{
                        $fields["photos"] = "";
                    }

                    if (!$hasError) {
                        $_SESSION["auction_info"] = array_merge($_SESSION["auction_info"], $fields);
                        $output["auction_info"] = $_SESSION["auction_info"];
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;

                } elseif ($step == 6) {

                    $record->reserve_price = (isset($_SESSION["auction_info"]["reserve_price"])) ? floatval($_SESSION["auction_info"]["reserve_price"]) : 0;
                    $record->starting_bid_price = (isset($_SESSION["auction_info"]["starting_bid_price"])) ? floatval($_SESSION["auction_info"]["starting_bid_price"]) : 0;
                    $record->buy_now_price = (isset($_SESSION["auction_info"]["buy_now_price"])) ? floatval($_SESSION["auction_info"]["buy_now_price"]) : 0;
                    $record->vin_number = (isset($_SESSION["auction_info"]["vin_number"])) ? trim($_SESSION["auction_info"]["vin_number"]) : "";
                    $record->auctions_length = (isset($_SESSION["auction_info"]["auctions_length"])) ? intval($_SESSION["auction_info"]["auctions_length"]) : 0;
                    if ($record->auctions_length == 60){
                        $record->expiration_date = date("Y-m-d H:i:s", time() + 60*60);
                    } else {
                        $record->expiration_date = date("Y-m-d H:i:s", strtotime("+" . $record->auctions_length . " days"));
                    }
                    $record->make = (isset($_SESSION["auction_info"]["make"])) ? FJF_BASE::ucname($_SESSION["auction_info"]["make"]) : "";
                    $record->model = (isset($_SESSION["auction_info"]["model"])) ? FJF_BASE::ucname($_SESSION["auction_info"]["model"]) : "";
                    $record->year = (isset($_SESSION["auction_info"]["year"])) ? intval($_SESSION["auction_info"]["year"]) : 0;
                    $record->engine = (isset($_SESSION["auction_info"]["engine"])) ? trim($_SESSION["auction_info"]["engine"]) : "";
                    $record->number_of_cylinders = (isset($_SESSION["auction_info"]["number_of_cylinders"])) ? intval($_SESSION["auction_info"]["number_of_cylinders"]) : 0;
                    $record->number_of_doors = (isset($_SESSION["auction_info"]["number_of_doors"])) ? intval($_SESSION["auction_info"]["number_of_doors"]) : 0;
                    $record->trim = (isset($_SESSION["auction_info"]["trim"])) ? trim($_SESSION["auction_info"]["trim"]) : "";
                    $record->trim2 = (isset($_SESSION["auction_info"]["trim2"])) ? trim($_SESSION["auction_info"]["trim2"]) : "";
                    $record->drive_type = (isset($_SESSION["auction_info"]["drive_type"])) ? trim($_SESSION["auction_info"]["drive_type"]) : "";
                    $record->color = (isset($_SESSION["auction_info"]["color"]) && array_key_exists($_SESSION["auction_info"]["color"], $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"])) ? $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"][$_SESSION["auction_info"]["color"]] : "";
                    $record->interior_color = (isset($_SESSION["auction_info"]["interior_color"]) && array_key_exists($_SESSION["auction_info"]["interior_color"], $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_interior_colors"])) ? $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_interior_colors"][$_SESSION["auction_info"]["interior_color"]] : "";
                    $record->auction_condition = (isset($_SESSION["auction_info"]["auction_condition"])) ? $_SESSION["auction_info"]["auction_condition"] : "";
                    $record->mileage = (isset($_SESSION["auction_info"]["mileage"])) ? $_SESSION["auction_info"]["mileage"] : "";
                    $record->fuel_type = (isset($_SESSION["auction_info"]["fuel_type"])) ? $_SESSION["auction_info"]["fuel_type"] : "";
                    $record->title_status = (isset($_SESSION["auction_info"]["title_status"])) ? $_SESSION["auction_info"]["title_status"] : "";
                    $record->title_wait_time = (isset($_SESSION["auction_info"]["title_wait_time"])) ? $_SESSION["auction_info"]["title_wait_time"] : "";
                    $record->transmission = (isset($_SESSION["auction_info"]["transmission"])) ? $_SESSION["auction_info"]["transmission"] : "";
                    $record->sell_to = (isset($_SESSION["auction_info"]["sell_to"]) && intval($_SESSION["auction_info"]["sell_to"]) > 0) ? intval($_SESSION["auction_info"]["sell_to"]) : 2;
                    $record->description = (isset($_SESSION["auction_info"]["description"])) ? $_SESSION["auction_info"]["description"] : "";
                    $record->terms_condition_id = (isset($_SESSION["auction_info"]["terms_condition_id"]) && $_SESSION["auction_info"]["terms_condition_id"] > 0) ? $_SESSION["auction_info"]["terms_condition_id"] : 0;
                    $record->terms_conditions = (isset($_SESSION["auction_info"]["terms_condition"])) ? $_SESSION["auction_info"]["terms_condition"] : "";
                    $record->additional_fees_id = (isset($_SESSION["auction_info"]["additional_fees_id"]) && $_SESSION["auction_info"]["additional_fees_id"] > 0) ? $_SESSION["auction_info"]["additional_fees_id"] : 0;
                    $record->additional_fees = (isset($_SESSION["auction_info"]["additional_fees"])) ? $_SESSION["auction_info"]["additional_fees"] : "";
                    $record->payment_pickup_id = (isset($_SESSION["auction_info"]["payment_pickup_id"]) && $_SESSION["auction_info"]["payment_pickup_id"] > 0) ? $_SESSION["auction_info"]["payment_pickup_id"] : 0;
                    $record->payment_method = (isset($_SESSION["auction_info"]["payment_method"])) ? $_SESSION["auction_info"]["payment_method"] : null;

                    if(is_string($record->payment_method) && $record->payment_method != ""){
                         $record->payment_method = $record->payment_method;
                    }elseif($record->payment_pickup_id == 0 && !empty($record->payment_method)){
                        $record->payment_method = implode(",", $record->payment_method);
                    }else{
                        $record->payment_method = "";
                    }

                    $record->pickup_window = (isset($_SESSION["auction_info"]["pickup_window"])) ? intval($_SESSION["auction_info"]["pickup_window"]) : 0;
                    $record->pickup_note = (isset($_SESSION["auction_info"]["pickup_note"])) ? $_SESSION["auction_info"]["pickup_note"] : "";

                    $record->photos = (isset($_SESSION["auction_info"]["photos"])) ? $_SESSION["auction_info"]["photos"] : null;
                    $record->user_id = $userID;
                    $record->auction_status = $auctionStatus = ($action == "create" || $action == "relist") ? "Active" : $record->auction_status;

                    if (!$hasError) {

                        if ($action == "relist") {
                            $record->disallow_accept_highest_bid = 1;
                            $record->auction_status = "Canceled";
                            $editor->saveAndPublish();

                            unset($editor);
                            unset($record->id);
                            unset($record->revision_id);
                            unset($record->revision_status);
                            unset($record->revision_tag);

                            $editorRelistParams = array(
                                "id" => null,
                                "table" => "auctions",
                                "title_field" => "title",
                                "positions" => true
                            );
                            $editorRelist = new AdminEditRevisionsModel($editorRelistParams);
                            $recordRelist = $editorRelist->loadRecord();
                            $recordRelist->title = $record->make . " " . $record->model . " " . $record->year;
                            $recordRelist->reserve_price = $record->reserve_price;
                            $recordRelist->starting_bid_price = $record->starting_bid_price;
                            $recordRelist->buy_now_price = $record->buy_now_price;
                            $recordRelist->vin_number = $record->vin_number;
                            $recordRelist->auctions_length = $record->auctions_length;
                            $recordRelist->expiration_date = $record->expiration_date;
                            $recordRelist->make = $record->make;
                            $recordRelist->model = $record->model;
                            $recordRelist->year = $record->year;
                            $recordRelist->engine = $record->engine;
                            $recordRelist->number_of_cylinders = $record->number_of_cylinders;
                            $recordRelist->number_of_doors = $record->number_of_doors;
                            $recordRelist->trim = $record->trim;
                            $recordRelist->trim2 = $record->trim2;
                            $recordRelist->drive_type = $record->drive_type;
                            $recordRelist->color = $record->color;
                            $recordRelist->interior_color = $record->interior_color;
                            $recordRelist->auction_condition = $record->auction_condition;
                            $recordRelist->mileage = $record->mileage;
                            $recordRelist->fuel_type = $record->fuel_type;
                            $recordRelist->title_status = $record->title_status;
                            $recordRelist->title_wait_time = $record->title_wait_time;
                            $recordRelist->transmission = $record->transmission;
                            $recordRelist->sell_to = $record->sell_to;
                            $recordRelist->description = $record->description;
                            $recordRelist->terms_condition_id = $record->terms_condition_id;
                            $recordRelist->terms_conditions = $record->terms_conditions;
                            $recordRelist->additional_fees_id = $record->additional_fees_id;
                            $recordRelist->additional_fees = $record->additional_fees;
                            $recordRelist->payment_pickup_id = $record->payment_pickup_id;
                            $recordRelist->payment_method = $record->payment_method;
                            $recordRelist->pickup_window = $record->pickup_window;
                            $recordRelist->pickup_note = $record->pickup_note;
                            $recordRelist->photos = $record->photos;
                            $recordRelist->user_id = $record->user_id;
                            $recordRelist->auction_status = $auctionStatus;

                            if (!$editorRelist->saveAndPublish()) {
                                $hasError = true;
                                $status = "An error occurred while saving record to DB.";
                            } else {
                                $status = "Relist successful auction.";
                                FJF_BASE_RICH::deleteRecords("auctions", "id ='AUCTION_ID'", array("AUCTION_ID" => $_REQUEST["id"]));

                            }
                            $output["record_id"] = $recordRelist->id;

                            $buyersWhoWatchedCurrentSeller = FJF_BASE_RICH::getRecords("users_sellers_favorites", "seller_id = " . $userID, [], false, "id, user_id");

                            if (!empty($buyersWhoWatchedCurrentSeller)) {
                                foreach ($buyersWhoWatchedCurrentSeller as $buyer) {
                                    $buyersIDs[] = $buyer->user_id;
                                }
                                $buyers = FJF_BASE_RICH::getRecords("users", "status = 1 AND id IN (" . implode(", ", $buyersIDs) . ")", [], false);
                                foreach ($buyers as $buyer) {
                                    //NEW AUCTION FROM WATCHED SELLER
                                    $notificationData["type"] = NotificationModel::TYPE_BUYER_NEW_AUCTION_FROM_WATCHED_SELLER;
                                    $notificationData["uid"] = $buyer->uid;
                                    $notificationData["notification"] = json_encode([
                                        "auction_id" => $recordRelist->id,
                                        "seller_name" => $user->name,
                                        "make" => $recordRelist->make,
                                        "model" => $recordRelist->model,
                                        "year" => $recordRelist->year,
                                        "status" => "New auction from ".$user->name,
                                        "starting_bid" => $recordRelist->starting_bid_price,
                                        "buy_now_price" => $recordRelist->buy_now_price,
                                        "expiration_date" => $recordRelist->expiration_date
                                    ]);
                                    $this->notificationModel->insertNotification($notificationData, $buyer);
                                }
                            }

                        } else {
                            if (!$editor->saveAndPublish()) {
                                $hasError = true;
                                $status = "An error occurred while saving record to DB.";
                            } else {
                                $status = "Create successful auction..";
                                if ($action == "create") {
                                    $buyersWhoWatchedCurrentSeller = FJF_BASE_RICH::getRecords("users_sellers_favorites", "seller_id = " . $userID, [], false, "id, user_id");
                                    if (!empty($buyersWhoWatchedCurrentSeller)) {
                                        foreach ($buyersWhoWatchedCurrentSeller as $buyer) {
                                            $buyersIDs[] = $buyer->user_id;
                                        }
                                        $buyers = FJF_BASE_RICH::getRecords("users", "status = 1 AND id IN (" . implode(", ", $buyersIDs) . ")", [], false);
                                        foreach ($buyers as $buyer) {
                                            //NEW AUCTION FROM WATCHED SELLER
                                            $notificationData["type"] = NotificationModel::TYPE_BUYER_NEW_AUCTION_FROM_WATCHED_SELLER;
                                            $notificationData["uid"] = $buyer->uid;
                                            $notificationData["notification"] = json_encode([
                                                "auction_id" => $record->id,
                                                "seller_name" => $user->name,
                                                "make" => $record->make,
                                                "model" => $record->model,
                                                "year" => $record->year,
                                                "status" =>  "New auction from ".$user->name,
                                                "starting_bid" => $record->starting_bid_price,
                                                "buy_now_price" => $record->buy_now_price,
                                                "expiration_date" => $record->expiration_date
                                            ]);
                                            $this->notificationModel->insertNotification($notificationData, $buyer);
                                        }
                                    }
                                }
                            }
                            $output["record_id"] = $record->id;
                        }
                    }

                    $output["status"] = $status;
                    $output["has_error"] = $hasError;

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($output));
                    exit;
                }

                if ($action == "upload_auction_images") {
                    set_time_limit(0);
                    $result = [];
                    $folder = SiteMediaModel::getFolder("auctions-images");
                    if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]) {
                        try {
                            $file = SiteMediaModel::uploadFile($folder, "file");
                            if ($file) {
                                $result["file"]["photo"] = $file->id;
                                $result["file"]["title"] = $file->name_orig;
                            }
                        } catch (Exception $e) {
                            $result["error"] = true;
                        }
                    }

                    header("Content-type: application/json; charset=utf-8");
                    print_r(json_encode($result));
                    exit;
                }
            }
        }
        $auctionTitleStatuses = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_title_statuses"];
        $auctionExteriorColors = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"];
        $auctionInteriorColors = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_interior_colors"];

        $templateParams = array(
            "user" => $user,
            "has_error" => $hasError,
            "status" => $status,
            "action" => $action,
            "record" => $record,
            "states" => $states,
            "content_blocks" => $contentBlocks,
            "title_statuses" => $auctionTitleStatuses,
            "exterior_colors" => $auctionExteriorColors,
            "interior_colors" => $auctionInteriorColors,
            "payment_pickup_block" => $paymentPickupContentBlocks,
            "payment_methods" => json_encode($GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"]),
            "interior_colors_js" => json_encode($GLOBALS["WEB_APPLICATION_CONFIG"]["auction_interior_colors"]),
            "exterior_colors_js" => json_encode($GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"]),
            "has_license_error" => $hasLicenseError,
            "license_status" => $licenseStatus,
            "default_terms_conditions" => $defaultTermsConditions,
            "default_additional_fees" => $defaultAdditionalFees
        );

        return $this->displayTemplate("auctions_edit.tpl", $templateParams);
    }

}

?>

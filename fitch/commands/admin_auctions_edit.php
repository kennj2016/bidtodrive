<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class AdminAuctionsEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Auctions');
        $this->setToolTitleSingular('Auction');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'auctions',
            'title_field' => 'title',
            'positions' => true
        ));

        $record = $editor->loadRecord();

        if (!$record) FJF_BASE::redirect("/admin/auctions/");

        $paymentMethods = $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"];
        $paymentMethodsField = new AdminAutocompleteField("payment_methods", $paymentMethods, true);

        $colorsArr = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_exterior_colors"];
        $auctionInteriorColors = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_interior_colors"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

                $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                $record->vin_number = isset($_POST["vin_number"]) ? trim($_POST["vin_number"]) : "";
                $record->make = isset($_POST["make"]) ? FJF_BASE::ucname($_POST["make"]) : "";
                $record->model = isset($_POST["model"]) ? FJF_BASE::ucname($_POST["model"]) : "";
                $record->year = isset($_POST["year"]) ? intval($_POST["year"]) : 0;
                $record->engine = isset($_POST["engine"]) ? trim($_POST["engine"]) : "";
                $record->number_of_cylinders = isset($_POST["number_of_cylinders"]) ? intval($_POST["number_of_cylinders"]) : 0;
                $record->transmission = isset($_POST["transmission"]) ? trim($_POST["transmission"]) : "";
                $record->number_of_doors = isset($_POST["number_of_doors"]) ? intval($_POST["number_of_doors"]) : 0;
                $record->options = isset($_POST["options"]) ? trim($_POST["options"]) : "";
                $record->color = isset($_POST["color"]) ? trim($_POST["color"]) : "";
                $record->interior_color = isset($_POST["interior_color"]) ? trim($_POST["interior_color"]) : "";
                $record->trim = isset($_POST["trim"]) ? trim($_POST["trim"]) : "";
                $record->trim2 = isset($_POST["trim2"]) ? trim($_POST["trim2"]) : "";

                $record->photos = array();
                $postArr = isset($_POST['photos']) && is_array($_POST['photos']) ? $_POST['photos'] : array();
                foreach ($postArr as $post) {
                    $item = array(
                        'title' => isset($post['title']) ? trim($post['title']) : '',
                        'photo' => isset($post['photo']) ? trim($post['photo']) : ''
                    );
                    if (!implode("", $item)) continue;
                    array_push($record->photos, $item);

                    if ($messages = $editor->validate(array(
                        'title' => array('label' => 'Title', 'required' => true),
                        'photo' => array('label' => 'Photo', 'required' => true)
                    ), (object)$item)) {
                        $hasError = true;
                        $status .= "Photo #" . count($record->photos) . ": " . implode("\n", $messages) . "\n";
                    }
                }
                $record->photos = json_encode($record->photos);

                $record->auction_condition = isset($_POST["auction_condition"]) ? trim($_POST["auction_condition"]) : "";
                $record->title_status = isset($_POST["title_status"]) ? trim($_POST["title_status"]) : "";
                $record->title_wait_time = isset($_POST["title_wait_time"]) ? trim($_POST["title_wait_time"]) : "";
                $record->mileage = isset($_POST["mileage"]) ? trim($_POST["mileage"]) : "";
                $record->fuel_type = isset($_POST["fuel_type"]) ? trim($_POST["fuel_type"]) : "";
                $record->terms_condition_id = isset($_POST["terms_condition_id"]) && intval($_POST["terms_condition_id"]) ? intval($_POST["terms_condition_id"]) : 0;
                $record->additional_fees_id = isset($_POST["additional_fees_id"]) && intval($_POST["additional_fees_id"]) ? intval($_POST["additional_fees_id"]) : 0;
                $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                $record->user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : 0;
                $record->auction_status = isset($_POST["auction_status"]) && $_POST["auction_status"] != "" ? $_POST["auction_status"] : "Active";
                $record->drive_type = isset($_POST["drive_type"]) ? trim($_POST["drive_type"]) : "";
                $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                $record->auctions_length = isset($_POST["auctions_length"]) ? intval($_POST["auctions_length"]) : 0;
                $record->sell_to = (isset($_POST["sell_to"]) && intval($_POST["sell_to"]) > 0) ? intval($_POST["sell_to"]) : 2;
                $record->pickup_window = isset($_POST["pickup_window"]) ? intval($_POST["pickup_window"]) : 0;
                $record->pickup_note = isset($_POST["pickup_note"]) ? trim($_POST["pickup_note"]) : "";
                $record->payment_pickup_id = isset($_POST["payment_pickup_id"]) ? intval($_POST["payment_pickup_id"]) : 0;
                $record->payment_method = $paymentMethodsField->getValue();
                $record->payment_method = isset($record->payment_method) && $record->payment_method != "" ? $record->payment_method : 1;
                $record->terms_conditions = isset($_POST["terms_conditions"]) ? trim($_POST["terms_conditions"]) : "";
                $record->additional_fees = isset($_POST["additional_fees"]) ? trim($_POST["additional_fees"]) : "";
                if ($record->auctions_length == 60){
                    $record->expiration_date = date("Y-m-d H:i:s", time() + 60*60);
                } else {
                    $record->expiration_date = date("Y-m-d H:i:s", strtotime("+" . $record->auctions_length . " days"));
                }

                if ($record->id == "") {
                    $record->starting_bid_price = isset($_POST["starting_bid_price"]) ? intval($_POST["starting_bid_price"]) : "";
                    $record->reserve_price = isset($_POST["reserve_price"]) ? intval($_POST["reserve_price"]) : "";
                    $record->buy_now_price = isset($_POST["buy_now_price"]) ? intval($_POST["buy_now_price"]) : "";
                }

                if (!$record->auctions_length) {
                    $hasError = true;
                    $status .= "Auction Length is missing. \n";
                } elseif (!is_numeric($record->auctions_length)) {
                    $hasError = true;
                    $status .= "Enter a valid Auction Length. \n";
                }

                if (!$record->vin_number) {
                    $hasError = true;
                    $status .= "Vin Number is missing. \n";
                }

                if ($record->user_id == 0) {
                    $hasError = true;
                    $status .= "User is missing. \n";
                }

                if (!$record->mileage) {
                    $hasError = true;
                    $status .= "Mileage is missing. \n";
                } elseif ($record->mileage && !is_numeric($record->mileage)) {
                    $hasError = true;
                    $status .= "Enter valid Mileage. \n";
                }

                if ($record->pickup_window && !is_numeric($record->pickup_window)) {
                    $hasError = true;
                    $status .= "Enter valid Pickup Window. \n";
                }
            }

            if (!$hasError) {
                if (!$record->title) {
                    $record->title = $record->year . " " . $record->make . " " . $record->model;
                }
                if ($editor->$method()) FJF_BASE::redirect("/admin/auctions/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $termsConditions = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type = 'Terms & Conditions'", false, false, "id, title");
        $additionalFees = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type = 'Additional Fees'", false, false, "id, title");
        $paymentPickup = FJF_BASE_RICH::getRecords("auctions_content_blocks", "type = 'Payment/Pickup'", false, false, "id, title");
        $users = FJF_BASE_RICH::getRecords("users", "user_type = 'Seller'", null, null, "id, name");

        $auctionBids = FJF_BASE_RICH::getRecords("auctions_bids", " winning_bid = 1", null, null, "user_id, auction_id, bid_price, winning_bid");
        $record->winning_bid = $auctionBids && array_key_exists($record->id, $auctionBids) ? $auctionBids[$record->id]->bid_price : 0;
        $record->buyer = $auctionBids && array_key_exists($record->id, $auctionBids) ? $auctionBids[$record->id]->user_id : "";
        $buyer = FJF_BASE_RICH::getRecord("users", "id = 'USER_ID'", array("USER_ID" => $record->buyer));
        if (is_object($buyer)) {
            $record->buyer_name = $buyer->name;
        }

        if (isset($record->payment_method)) $paymentMethodsField->setValue($record->payment_method);

        $this->setRecord($record);
        $this->addParentBreadCrumb('auctions', 'auctions');

        $conditionArr = array("Runs & Drives", "Must be towed");
        $titleWaitTimeArr = array("Title Available", "Up to 30 Days");
        $auctionTitleStatuses = $GLOBALS["WEB_APPLICATION_CONFIG"]["auction_title_statuses"];

        return $this->displayTemplate("admin_auctions_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "colors" => $colorsArr,
            "interior_colors" => $auctionInteriorColors,
            "conditions" => $conditionArr,
            "title_wait_times" => $titleWaitTimeArr,
            "terms_conditions" => $termsConditions,
            "additional_fees" => $additionalFees,
            "title_statuses" => $auctionTitleStatuses,
            "payment_pickup" => $paymentPickup,
            "payment_methods_arr" => isset($record->payment_method) ? $record->payment_method : "",
            "payment_methods_field" => $paymentMethodsField,
            "users" => $users
        ));
    }

}

?>
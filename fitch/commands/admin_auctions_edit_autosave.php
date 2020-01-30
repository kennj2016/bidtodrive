<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminAuctionsEditAutosave extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        $data = array();
        $hasError = false;
        $status = "";

        if (!$this->sessionModel->hasAdminPermissions()) {
            $hasError = true;
            $status = "Access denied.";
        } elseif (!isset($_GET['id']) || !trim($_GET['id'])) {
            $hasError = true;
            $status = "Invalid ID.";
        } else {
            $editor = new AdminEditRevisionsModel(array(
                'table' => 'auctions'
            ));

            if (!$record = $editor->loadRecord()) {

                $hasError = true;
                $status = "Record not found.";
            } else {
                $paymentMethods = $GLOBALS["WEB_APPLICATION_CONFIG"]["payment_methods"];
                $paymentMethodsField = new AdminAutocompleteField("payment_methods", $paymentMethods, true);
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
                    $record->user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : 0;
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

                    if ($revision = $editor->autosave()) {
                        $data['revision'] = $revision;
                    } else {
                        $hasError = true;
                        $status = "Autosave was failed.";
                    }

                } else {

                    $data['revisions'] = $editor->getRevisions();

                }
            }
        }

        exit(json_encode(
            array('has_error' => $hasError, 'status' => $status) + $data
        ));
    }

}

?>
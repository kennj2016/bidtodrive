<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AjaxAuctionsCancelAuction extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        SessionModel::requireUser();
    }

    function execute()
    {
        $output["has_error"] = false;
        $output["status"] = "";
        if ($this->isAjax() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $auctionID = (isset($_POST["auction_id"])) ? intval($_POST["auction_id"]) : 0;
            if ($auctionID > 0) {
                $sellerInfo = SessionModel::user();
                $editorParams = array(
                    "table" => "auctions",
                    "title_field" => "title",
                    "positions" => true,
                    "id" => $auctionID
                );
                $editor = new AdminEditRevisionsModel($editorParams);
                $record = $editor->loadRecord();
                if (is_object($record) && ($record->id == $auctionID) && (is_object($sellerInfo) && $sellerInfo->user_type == "Seller" && $sellerInfo->id == $record->user_id)) {
                    $record->auction_status = "Canceled";
                    $record->auction_completion_date = date("Y-m-d H:i:s");
                    $record->expiration_date = date("Y-m-d H:i:s");
                    $editor->saveAndPublish();
                    $output["status"] = "The auction has been canceled";
                    $output["has_error"] = true;
                    $output["code"] = 0;
                } else {
                    $output["status"] = "You are logged in as a buyer so you cannot bid on this product.";
                    $output["has_error"] = true;
                    $output["code"] = 1;
                }
                unset($record);
                unset($editor);
            } else {
                $output["status"] = "The auction code does not exist.";
                $output["has_error"] = true;
                $output["code"] = 1;
            }
        }
        header("Content-type: application/json; charset=utf-8");
        print_r(json_encode($output));
        exit;
    }
}

?>

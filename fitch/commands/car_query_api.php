<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class CarQueryApi extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
        $this->page = new PageModel();

        $code = isset($_REQUEST["vin"]) ? trim($_REQUEST["vin"]) : "";
        $save = isset($_REQUEST["save"]) ? trim($_REQUEST["save"]) : "";
        $apiURL = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVinValuesExtended/" . $code . "?format=json";
        $curl = curl_init($apiURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);
        $result = $result["Results"][0];
        if ($result["Make"] && $result["Model"] && $result["ModelYear"]) {

        } else {
            $result = null;
        }
        $auctionResult = null;
        if ($result && $save) {
            $auctionEditor = new AdminEditRevisionsModel(array("table" => "auctions"));
            $auctionRecord = $auctionEditor->loadRecord();
            $auctionRecord->title = $result["VIN"] . ": " . $result["Make"] . " " . $result["Model"];
            $auctionRecord->vin_number = $result["VIN"];
            $auctionRecord->make = $result["Make"];
            $auctionRecord->model = $result["Model"];
            $auctionRecord->year = $result["ModelYear"];
            $auctionRecord->engine = $result["EngineConfiguration"];
            if ($result["EngineModel"]) {
                $auctionRecord->engine .= $auctionRecord->engine ? " " : "" . $result["EngineModel"];
            }
            $auctionRecord->fuel_type = $result["FuelTypePrimary"];
            $auctionRecord->number_of_doors = $result["Doors"];
            $auctionRecord->number_of_cylinders = $result["EngineCylinders"];
            $auctionRecord->trim = $result["Trim"];
            $auctionRecord->trim2 = $result["Trim2"];
            unset($auctionRecord->id);
            $auctionResult = $auctionEditor->saveAndPublish();
        }

        return $this->displayTemplate("car_query_api.tpl", array(
            'result' => $result,
            'auction_result' => $auctionResult
        ));
    }

}

?>
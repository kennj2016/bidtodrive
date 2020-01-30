<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminTaxesEditAutosave extends FJF_CMD
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
                'table' => 'taxes'
            ));

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $record->rate = isset($_POST["rate"]) ? floatval($_POST["rate"]) : 0;
                    $record->zip_code = isset($_POST["zip_code"]) ? trim($_POST["zip_code"]) : "";
                    $record->city = isset($_POST["city"]) ? trim($_POST["city"]) : "";
                    $record->city_rate = isset($_POST["city_rate"]) ? floatval($_POST["city_rate"]) : 0;
                    $record->post_office = isset($_POST["post_office"]) ? trim($_POST["post_office"]) : "";
                    $record->state_id = isset($_POST["state_id"]) ? trim($_POST["state_id"]) : "";
                    $record->state = array_key_exists($record->state_id, $states) ? $states[$record->state_id]->abbr : "";
                    $record->state_rate = isset($_POST["state_rate"]) ? floatval($_POST["state_rate"]) : 0;
                    $record->state_reporting_code = isset($_POST["state_reporting_code"]) ? trim($_POST["state_reporting_code"]) : "";
                    $record->county = isset($_POST["county"]) ? trim($_POST["county"]) : "";
                    $record->county_rate = isset($_POST["county_rate"]) ? floatval($_POST["county_rate"]) : 0;
                    $record->county_reporting_code = isset($_POST["county_reporting_code"]) ? trim($_POST["county_reporting_code"]) : "";
                    $record->special_district_rate = isset($_POST["special_district_rate"]) ? floatval($_POST["special_district_rate"]) : 0;
                    $record->special_district_reporting_code = isset($_POST["special_district_reporting_code"]) ? trim($_POST["special_district_reporting_code"]) : "";
                    $record->shipping_taxable = isset($_POST["shipping_taxable"]) ? intval($_POST["shipping_taxable"]) : 0;
                    $record->primary_record = isset($_POST["primary_record"]) ? intval($_POST["primary_record"]) : 0;
                    $record->z2t_id = isset($_POST["z2t_id"]) ? trim($_POST["z2t_id"]) : "";
                    $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

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
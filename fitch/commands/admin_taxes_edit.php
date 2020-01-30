<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminTaxesEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Taxes');
        $this->setToolTitleSingular('Tax');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'taxes',
            'title_field' => 'city',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/taxes/");

        $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
        $states = FJF_BASE_RICH::getRecords("states", "TRUE ORDER BY name");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

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

                if ($messages = $editor->validate(array(
                    'zip_code' => array('label' => 'ZIP Code', 'required' => true),
                    'city' => array('label' => 'City', 'required' => true),
                    'post_office' => array('label' => 'Post Office', 'required' => true),
                    'state_id' => array('label' => 'State', 'required' => true),
                    'county' => array('label' => 'County', 'required' => true)
                ))) {
                    $hasError = true;
                    $status = implode("\n", $messages);
                }

            }

            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/taxes/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('taxes');

        return $this->displayTemplate("admin_taxes_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "states" => $states
        ));
    }

}

?>
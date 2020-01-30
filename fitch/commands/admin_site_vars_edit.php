<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminSiteVarsEdit extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Site Vars');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/site_vars/";
        }

        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        $record = $id ? FJF_BASE_RICH::getRecordBy("site_vars", $id) : null;
        if (!$record) FJF_BASE::redirect($header["return"]);

        $hasError = false;
        $status .= "";

        $header["parent"] = array("site_vars" => "Manage Site Vars");
        $header["title"] = "Edit Site Var";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->value = isset($_POST['value']) ? trim($_POST['value']) : '';

            if ($record->type == "bool") {
                $record->value = $record->value ? 1 : 0;
            } elseif ($record->type == "date") {
                if ($record->value) {
                    $record->value = date("Y-m-d", strtotime($record->value));
                }
            } elseif ($record->type == "datetime") {
                if ($record->value) {
                    $record->value = date("Y-m-d H:i:s", strtotime($record->value));
                }
            } elseif ($record->type == "time") {
                if ($record->value) {
                    $record->value = date("H:i:s", strtotime($record->value));
                }
            }

            if ($record->name == "buyer_fee_commission") {
                if (!is_numeric($record->value)) {
                    $hasError = true;
                    $status .= "It must be numeric value.";
                } elseif ($record->value < 0) {
                    $hasError = true;
                    $status .= "Value should be greater than zero.";
                } elseif ($record->value > 100) {
                    $hasError = true;
                    $status .= "Value should be less than zero.";
                }
            }

            if (!$hasError) {
                if (FJF_BASE_RICH::saveRecord("site_vars", array(
                    'id' => $record->id,
                    'value' => $record->value
                ))) {
                    $status = "Data was saved successfully.";
                } else {
                    $hasError = true;
                    $status .= "An error occurred while saving record to DB.\n";
                }
            }
        }//POST

        $this->addParentBreadCrumb('site_vars');
        $this->setRecord($record);

        return $this->displayTemplate("admin_site_vars_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
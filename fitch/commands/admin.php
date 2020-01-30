<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class Admin extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Dashboard');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (isset($_POST['tools']) && is_array($_POST['tools'])) {

            if (!SessionModel::isSuperAdmin()) {
                $hasError = true;
                $status = "Access denied.";
            } else {

                include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");

                $editor = new AdminSiteDataEditor("admin-settings", "tools-order");
                $data = $editor->loadRecord();

                $data->blocks = array_map("strtolower", $_POST['tools']);

                if (!$editor->saveRecord()) {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }

            }

            return $this->displayJSON(array(
                "has_error" => $hasError,
                "status" => $status
            ));
        }

        return $this->displayTemplate("admin.tpl", array(
            "header" => $header
        ));
    }

}

?>
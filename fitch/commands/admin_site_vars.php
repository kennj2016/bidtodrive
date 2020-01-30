<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminSiteVars extends FJF_CMD
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

        $records = FJF_BASE_RICH::getRecords("site_vars");
        $total = $records ? count($records) : 0;

        return $this->displayTemplate("admin_site_vars.tpl", array(
            "header" => $header,
            "total" => $total,
            "records" => $records
        ));
    }

}

?>
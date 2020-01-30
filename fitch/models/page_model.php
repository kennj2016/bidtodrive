<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/common_page_model.php");

class PageModel extends CommonPageModel
{
    function __construct()
    {
        parent::__construct();

        $this->loadSeoSettings();
        $this->setNavigations();
    }

    function setNavigations()
    {
        if ($navigations = FJF_BASE_RICH::getRecords("navigation")) {
            foreach ($navigations as $navigation) {
                $this->setNavigation($navigation->title, json_decode($navigation->items));
            }
        }
    }

    function getAllContactReasons()
    {
        return FJF_BASE_RICH::getRecords("contact_reasons", "", null, null, "id, title");
    }

    function getAdminPermissions()
    {
        $user = SessionModel::sessionUser();
        return $user && $user->is_admin;
    }

}

?>
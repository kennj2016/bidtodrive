<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminNavigation extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Navigation');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $navigation = isset($_POST["navigation"]) ? trim($_POST["navigation"]) : "";

            if (FJF_BASE::db_open()) {
                FJF_BASE::db_execute("TRUNCATE TABLE navigation");
                FJF_BASE::db_close();
            }

            if ($navigation) {
                $navigation = json_decode($navigation);
                if (!empty($navigation)) {
                    foreach ($navigation as $nav) {
                        $nav->items = $this->generateItemsUrls($nav->items);
                        $nav->items = json_encode($nav->items);
                        FJF_BASE_RICH::saveRecord("navigation", get_object_vars($nav));
                    }
                }
            }
        }//POST

        $records = FJF_BASE_RICH::getRecords("navigation");
        if (!empty($records)) {
            foreach ($records as $record) {
                if ($record->items) $record->items = json_decode($record->items);
            }
        }

        return $this->displayTemplate("admin_navigation.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "records" => $records
        ));
    }

    function generateItemsUrls($records, $parentUrl = "")
    {
        if (!empty($records)) {
            foreach ($records as $record) {
                if (strpos($record->link, 'rel:') === 0) {
                    $record->url = '';
                    $record->rel = substr($record->link, 4);
                } elseif ($record->is_external) {
                    $record->url = $record->link;
                } else {
                    $url = "/" . trim($record->link, "/") . "/";
                    if (strpos($url, '?')) $url = rtrim($url, "/");
                    if (!$record->link) $record->url = "";
                    elseif ($record->link == '/') $record->url = "/";
                    elseif (strpos($record->link, '/') === 0) $record->url = $url;
                    elseif ($parentUrl) $record->url = rtrim($parentUrl, "/") . $url;
                    else $record->url = $url;
                }
                $record->items = $this->generateItemsUrls($record->items, $record->url);
            }
        }
        return $records;
    }

}

?>
<?php

class SiteVarsModel
{

    private static $vars;

    function getVar($name)
    {
        SiteVarsModel::init();
        return isset(SiteVarsModel::$vars[$name]) ? SiteVarsModel::$vars[$name] : null;
    }//getVar

    function getVars($name)
    {
        SiteVarsModel::init();
        return SiteVarsModel::$vars;
    }//getVars

    private function init()
    {
        if (!isset(SiteVarsModel::$vars)) {
            SiteVarsModel::$vars = array();
            if ($records = FJF_BASE_RICH::getRecords("site_vars")) {
                foreach ($records as $record) {
                    if ($record->type == 'bool') $record->value = (bool)$record->value;
                    elseif ($record->type == 'file') $record->value = $record->value ? "/files/site_vars/" . $record->value : null;
                    SiteVarsModel::$vars[$record->name] = $record->value;
                }
            }
        }
    }//init

}

?>
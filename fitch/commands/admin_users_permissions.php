<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AdminUsersPermissions extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Permissions');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/administrators/";
        }

        $parentId = isset($_GET["parent_id"]) ? intval($_GET["parent_id"]) : 0;
        $parent = $parentId ? FJF_BASE_RICH::getRecordBy("users", $parentId) : null;
        if (!$parent) FJF_BASE::redirect($header["return"]);

        $record = FJF_BASE_RICH::getRecordBy("admin_permissions", $parent->id, "user_id");
        if (!$record) $record = (object)array(
            "user_id" => $parent->id,
            "permissions" => ""
        );

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->permissions = isset($_POST["permissions"]) && is_array($_POST["permissions"]) ? $_POST["permissions"] : array();
            $record->permissions = join(",", $record->permissions);

            if (!$hasError) {
                if (FJF_BASE_RICH::saveRecord("admin_permissions", get_object_vars($record))) {
                    $status = "Data was saved successfully.";
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }//POST

        $record->permissions = $record->permissions ? explode(",", $record->permissions) : array();

        $this->setRecord($parent);
        $this->addParentBreadCrumb('administrators', 'Administrators')
            ->addParentBreadCrumb($parentId, (isset($parent->name) ? $parent->name : $parentId));

        $tools = FJF_BASE_RICH::getRecords("admin_tools", "TRUE ORDER BY title");

        return $this->displayTemplate("admin_users_permissions.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "tools" => $tools
        ));
    }

    public function getCurrentBreadCrumb()
    {
        return parent::getCurrentBreadCrumb() . "'s permissions";
    }

}

?>
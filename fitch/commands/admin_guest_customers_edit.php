<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminGuestCustomersEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Guest Customers');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditModel(array(
            'table' => 'guest_customers'
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/guest_customers/");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
            $record->email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
            $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;

            if (!$record->name) {
                $hasError = true;
                $status .= "Name cannot be blank.\n";
            }

            if (!$record->email) {
                $hasError = true;
                $status .= "Email cannot be blank.\n";
            } elseif (!preg_match("/^.+\@.+\..+$/", $record->email)) {
                $hasError = true;
                $status .= "Invalid Email format.\n";
            }

            if ($messages = $editor->validate(array(
                'name' => array('required' => true),
                'email' => array('required' => true, 'format' => 'email'),
            ))) {
                $hasError = true;
                $status = implode("\n", $messages);
            }

            if (!$hasError) {
                if ($editor->saveRecord()) FJF_BASE::redirect("/admin/guest_customers/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('guest_customers');

        return $this->displayTemplate("admin_guest_customers_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
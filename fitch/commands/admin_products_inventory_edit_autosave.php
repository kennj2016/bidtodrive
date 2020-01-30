<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminProductInventoryEditAutosave extends FJF_CMD
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
            $editor = new AdminEditRevisionsCustomModel(array(
                'table' => 'products'
            ));
            $id = isset($_GET['id']) ? trim($_GET['id']) : null;

            $ids = explode(".", $id);
            $id = $ids[0];

            $editor->setId($id);

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $varId = $ids[1];
                    $amount = isset($_POST["amount"]) ? trim($_POST["amount"]) : 0;
                    $note = isset($_POST["note"]) ? trim($_POST["note"]) : "";

                    $fields["product_id"] = $id;
                    $fields["variation_id"] = $varId;
                    $fields["description"] = $note;
                    $fields["datetime_create"] = date("Y-m-d H:i:s");

                    if ($amount >= 0) {
                        if (isset($record->variations) && $record->variations) {
                            foreach ($record->variations as $variation) {
                                if ($variation->id == $varId) {
                                    $variation->amount = $amount;
                                }
                            }
                            $record->variations = json_encode($record->variations);
                        }
                    }

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

class AdminEditRevisionsCustomModel extends AdminEditRevisionsModel
{
    function setId($id = null)
    {
        $this->id = $id;
    }
}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminProductInventoryEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Product Inventory');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsCustomModel(array(
            'table' => 'products'
        ));
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;

        $ids = explode(".", $id);
        $id = $ids[0];
        $varId = $ids[1];

        $amount = null;
        $sku = null;
        $history = null;
        $fields = array();
        $saveHistory = null;

        $editor->setId($id);
        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/products_inventory/");

        if (isset($record->variations) && $record->variations) {
            $record->variations = json_decode($record->variations);
            foreach ($record->variations as $variation) {
                if ($variation->id == $varId) {
                    $amount = $variation->amount;
                    $sku = $variation->sku;
                } else {
                    FJF_BASE::redirect("/admin/products_inventory/");
                }
            }
        }
        $history = FJF_BASE_RICH::getRecords("products_variations_history", "product_id ='PRODUCT_ID' AND sku='SKU' ORDER BY datetime_create DESC", array("PRODUCT_ID" => $id, "SKU" => $sku));
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $amount = isset($_POST["amount"]) ? trim($_POST["amount"]) : 0;
            $note = isset($_POST["note"]) ? trim($_POST["note"]) : "";

            $fields["product_id"] = $id;
            $fields["sku"] = $sku;
            $fields["description"] = $note;
            $fields["datetime_create"] = date("Y-m-d H:i:s");
            if ($amount >= 0) {
                if (!$note) {
                    $hasError = true;
                    $status .= "Note cannot be blank.\n";
                }
            }
            if ($amount >= 0) {
                $saveHistory = 1;
                if (isset($record->variations) && $record->variations) {
                    foreach ($record->variations as $variation) {
                        if ($variation->id == $varId) {
                            $variation->amount = $amount;
                            $variation->remaining = $amount;
                        }
                    }
                    $record->variations = json_encode($record->variations);
                }
            } else {
                $saveHistory = 0;
                $newVariation = array();
                if (isset($record->variations) && $record->variations) {
                    foreach ($record->variations as $variation) {
                        if ($variation->id != $varId) {
                            array_push($newVariation, $variation);
                        }
                    }
                    $record->variations = json_encode($newVariation);
                }
            }
            if (!$hasError) {
                if ($saveHistory)
                    $result = FJF_BASE_RICH::saveRecord("products_variations_history", $fields);
                else
                    $result = FJF_BASE_RICH::deleteRecords("products_variations_history", "product_id ='PRODUCT_ID' AND sku='SKU'", array("PRODUCT_ID" => $id, "SKU" => $sku));

                $res = FJF_BASE_RICH::saveRecord("products", array("id" => $record->id, "variations" => $record->variations));
                $res_rev = FJF_BASE_RICH::saveRecord("products_revisions", array("revision_id" => $record->revision_id, "variations" => $record->variations), "revision_id");

                if ($result && $res && $res_rev) FJF_BASE::redirect("/admin/products_inventory/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('products_inventory');

        return $this->displayTemplate("admin_products_inventory_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "amount" => $amount,
            "history" => $history,
            "record" => $record,
            "id" => $id
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
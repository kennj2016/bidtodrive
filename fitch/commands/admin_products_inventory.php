<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminProductInventory extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Product Inventory');
        $this->setToolTitleSingular('Product Inventory');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("products");
            $manager->hasRevisions();

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }
            if (key_exists("id", $_POST)) {
                $res = null;
                $res_rev = null;
                $output = array();
                $id = $_POST["id"];
                $ids = explode(".", $id);
                $id = $ids[0];
                $varId = $ids[1];

                $record = $id ? FJF_BASE_RICH::getRecordBy("products", $id) : null;

                $record_rev = $id ? FJF_BASE_RICH::getRecords("products_revisions", "id=" . $id . " ORDER BY revision_id desc", null, true) : null;
                if ($record && $record_rev) {
                    if ($record->variations && $record_rev->variations) {
                        $record->variations = json_decode($record->variations);
                        foreach ($record->variations as $variation) {
                            if ($variation->id == $varId)
                                $variation->statuses = $variation->statuses ? 0 : 1;
                        }
                        $record->variations = json_encode($record->variations);
                        $record_rev->variations = json_decode($record_rev->variations);
                        foreach ($record_rev->variations as $variation) {
                            if ($variation->id == $varId)
                                $variation->statuses = $variation->statuses ? 0 : 1;
                        }
                        $record_rev->variations = json_encode($record_rev->variations);

                        $res = FJF_BASE_RICH::saveRecord("products", array("id" => $record->id, "variations" => $record->variations));
                        $res_rev = FJF_BASE_RICH::saveRecord("products_revisions", array("id" => $record->id, "variations" => $record_rev->variations));
                    }
                }
                if (($res != null) && ($res_rev != null)) {
                    $output["has_records"] = false;
                } else {
                    $output["has_records"] = true;
                }
                print(json_encode($output));
                exit;

            }

        }//POST

        $manager = new CustomManager();
        $manager->setOption(array(
            'table' => 'products'
        ));

        $manager->addFilter('title');

        if ($categories = FJF_BASE_RICH::getList("product_categories")) {
            $manager->setData(array(
                'categories' => $categories
            ));
            $manager->addFilter(array(
                'id' => 'category',
                'field' => 'category_id',
                'type' => 'select',
                'options' => $categories
            ));
        }
        /*
        $manager->addFilters(array(

            array(
      'id' => 'sku',
      'type' => 'text'
    ),
    array(
                'id' => 'statuses',
                'type' => 'select',
                'options' => array(
                    1 => 'Available',
                    0 => 'Out of Stock'
                )
            )
        ));
        */
        $manager->addCols(array(
            new Id_AdminManagerCol,
            array(
                'id' => 'sku',
                'label' => "sku",
                'field' => 'sku',
                'width' => 1,
                'action' => 'edit'
            ),
            array(
                'id' => 'sku_pv',
                'label' => "Original Inventory",
                'field' => 'sku_pv',
                'width' => 1,
                'action' => 'edit'
            ),
            array(
                'id' => 'sold',
                'width' => 1,
                'action' => 'edit'
            ),
            array(
                'id' => 'remaining',
                'width' => 1,
                'action' => 'edit'
            ),
            new Title_AdminManagerCol(array(
                'id' => 'title'
            )),

            array(
                'id' => 'category',
                'action' => 'edit'
            ),
            new Statuses_AdminManagerCol
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/products_inventory/%id%/'
            ))
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_products.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_products_inventory.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }
}

class Statuses_AdminManagerCol extends AdminManagerCol
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'statuses', 'field' => 'statuses', 'label' => 'status', 'sort_reverse' => true, 'width' => 1
        ), $data));
    }

    function html($row)
    {
        return $row->{$this->field} ? '<a href = "javascript:void(0);" onclick="changeStatuses(' . $row->id . ');" ><span class="text-green changeStatuses' . str_replace(".", "_", $row->id) . '">Available</span></a>' : '<a href = "javascript:void(0);" onclick="changeStatuses(' . $row->id . ');"><span class="text-red changeStatuses' . str_replace(".", "_", $row->id) . '">Out of Stock</span></a>';
    }

}

class CustomManager extends AdminManager
{

    function getRows()
    {
        $sql = "SELECT r.*  FROM " . $this->getOption('table') . " r";
        if ($sqlWhere = $this->sqlWhere()) $sql .= " WHERE " . $sqlWhere;
        $sql .= $this->sqlOrder() . $this->sqlLimit();
        $records = FJF_BASE_RICH::selectRecords($sql, $this->sqlParams());
        $recordsNew = array();
        if ($categories = $this->getData("categories")) {
            foreach ($records as $record) {
                $record->category = array_key_exists($record->category_id, $categories) ? $categories[$record->category_id] : '';

                if ($record->variations != "") {
                    $record->variations = json_decode($record->variations);
                    if (is_array($record->variations)) {
                        $variations = $record->variations;
                        foreach ($variations as $variation) {
                            $variation->id = $record->id . "." . $variation->id;
                            $variation->category_id = $record->category_id;
                            $variation->category = $record->category;
                            $variation->sku_pv = $record->sku;
                            array_push($recordsNew, $variation);
                        }
                    }
                }
            }
        }
        return $recordsNew;
    }
}

?>
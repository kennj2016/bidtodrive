<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminProducts extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Products');
        $this->setToolTitleSingular('Product');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("products");
            $manager->hasPositions();
            $manager->hasRevisions();

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction("duplicate", null, null, null, 'title');

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $manager = new CustomManager();
        $manager->hasPositions();
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

        $manager->addFilters(array(
            array(
                'id' => 'date',
                'field' => 'datetime_create',
                'type' => 'date'
            ),
            array(
                'id' => 'price',
                'type' => 'range',
                'options' => array('symbol' => '$', 'min' => 0, 'max' => 10000)
            ),
            array(
                'id' => 'status',
                'type' => 'select',
                'options' => array(
                    1 => 'Active',
                    0 => 'Inactive'
                )
            )
        ));

        $manager->addCols(array(
            new Id_AdminManagerCol,
            array(
                'id' => 'sku',
                'width' => 1,
                'action' => 'edit'
            ),
            new Title_AdminManagerCol(array(
                'id' => 'title'
            )),
            new Date_AdminManagerCol(array(
                'field' => 'datetime_create'
            )),
            array(
                'id' => 'category',
                'action' => 'edit'
            ),
            array(
                'id' => 'price',
                'width' => 1,
                'action' => 'edit'
            ),
            new Approved_AdminManagerCol
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/products/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove'),
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/products/%id%/'
            )),
            new Toggle_Row_AdminManagerAction,
            'duplicate', 'delete'
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

        return $this->displayTemplate("admin_products.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }
}

class CustomManager extends AdminManager
{

    function getRows()
    {
        if ($records = parent::getRows()) {
            if ($categories = $this->getData("categories")) {
                foreach ($records as $record) {
                    $record->category = array_key_exists($record->category_id, $categories) ? $categories[$record->category_id] : '';
                }
            }
        }
        return $records;
    }

}

?>
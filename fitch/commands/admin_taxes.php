<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminTaxes extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Taxes');
        $this->setToolTitleSingular('Tax');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("taxes");
            $manager->hasPositions();
            $manager->hasRevisions();

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction("duplicate", null, null, null, 'city');

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
        $states = FJF_BASE_RICH::getRecords("states", "TRUE ORDER BY name");

        $manager = new AdminManager();
        $manager->hasPositions();
        $manager->setOption(array(
            'table' => 'taxes'
        ));

        $manager->addFilters(array(
            array(
                'id' => 'zip',
                'field' => 'zip_code'
            ),
            'city',
            array(
                'id' => 'state',
                'field' => 'state_id',
                'type' => 'select',
                'options' => FJF_BASE_RICH::toList($states, "id", "name")
            ),
            'rate',
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
            new Title_AdminManagerCol(array(
                'id' => 'zip',
                'field' => 'zip_code'
            )), array(
                'id' => 'city',
                'field' => 'city'
            ), array(
                'id' => 'state',
                'field' => 'state'
            ), array(
                'id' => 'rate',
                'field' => 'rate'
            ),
            new Approved_AdminManagerCol
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/taxes/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove'),
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/taxes/%id%/'
            )),
            new Toggle_Row_AdminManagerAction,
            'duplicate', 'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_taxes.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_taxes.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }
}

?>
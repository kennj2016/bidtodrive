<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminGuestCustomers extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Guest Customers');
        $this->setToolTitleSingular('Guest Customer');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("guest_customers");

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction("duplicate", null, null, null, 'name');

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $manager = new AdminManager();
        $manager->setOption(array(
            'table' => 'guest_customers',
            'default_sort' => 'id'
        ));

        $manager->addFilters(array(
            'name',
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
                'id' => 'name'
            )),
            array(
                'id' => 'email',
                'action' => 'edit'
            )
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/guest_customers/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove')
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/guest_customers/%id%/'
            ))
        ));

        $manager->addRowActions(array(
            new Toggle_Row_AdminManagerAction(),
            'duplicate', 'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_guest_customers.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_guest_customers.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

?>
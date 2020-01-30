<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminContentBlocks extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Content Blocks');
        $this->setToolTitleSingular('Content Block');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("auctions_content_blocks");
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

        $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
        $users = FJF_BASE_RICH::getRecords("users", "", null, null, "id, name");

        $manager = new CustomManager();
        $manager->setOption(array(
            'table' => 'auctions_content_blocks'
        ));
        $manager->setData("users", $users);

        $manager->addFilters(array(
            array(
                'id' => 'title',
                'field' => 'title',
                'label' => 'title'
            ),
            array(
                'id' => 'name',
                'field' => 'user_id',
                'label' => 'user',
                'type' => 'select',
                'options' => FJF_BASE_RICH::toList($users, "id", "name")
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
            new Title_AdminManagerCol(array(
                'id' => 'title'
            )),
            new Title_AdminManagerCol(array(
                'id' => 'user_id',
                'field' => 'name',
                'label' => 'user'
            )),
            new Approved_AdminManagerCol
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/content_blocks/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove'),
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/content_blocks/%id%/'
            )),
            new Toggle_Row_AdminManagerAction,
            'duplicate', 'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_content_blocks.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_content_blocks.tpl", array(
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
        $rows = parent::getRows();
        $users = $this->getData("users");

        if ($rows) {
            foreach ($rows as $row) {
                $row->name = $users && array_key_exists($row->user_id, $users) ? $users[$row->user_id]->name : "";
            }
        }

        return $rows;
    }

}

?>
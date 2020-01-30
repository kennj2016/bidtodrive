<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminWorkflow extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Workflow');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $action = isset($_POST['action']) ? $_POST['action'] : null;
            $ids = isset($_POST['ids']) ? $_POST['ids'] : null;
            if ($ids && $action) {
                $manager = new WorkflowManageModel('workflow');
                if ($action == 'deny') {
                    $manager->deleteRecords($ids);
                } elseif ($action == 'approve') {
                    $manager->approveRecords($ids);
                }
            }

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
        if ($users = FJF_BASE_RICH::getRecords("users", "is_admin=1 ORDER BY name")) {
            foreach ($users as $i => $user) $users[$i] = $user->name;
        }

        $types = array("faq" => "FAQ");
        $links = array("jobs" => "/admin/jobs/%id%/");
        if ($tmpArr = FJF_BASE_RICH::getRecords("workflow", null, null, null, "DISTINCT content_type")) {
            foreach ($tmpArr as $tmpItem) {
                if (!array_key_exists($tmpItem->content_type, $types)) {
                    $types[$tmpItem->content_type] = ucwords(str_replace("_", " ", $tmpItem->content_type));
                }
                if (!array_key_exists($tmpItem->content_type, $links)) {
                    $links[$tmpItem->content_type] = "/admin/" . $tmpItem->content_type . "/%id%/";
                }
            }
        }
        asort($types);

        $manager = new WorkflowManager();
        $manager->setOption(array(
            'table' => 'workflow'
        ));
        $manager->setData(array(
            'users' => &$users,
            'types' => &$types,
            'links' => &$links
        ));

        $manager->addFilters(array(
            array(
                'id' => 'title',
                'field' => 'content_title'
            ),
            array(
                'id' => 'type',
                'field' => 'content_type',
                'type' => 'select',
                'options' => $types
            )
        ));
        if ($users) {
            $manager->addFilter(array(
                'id' => 'user',
                'field' => 'user_id',
                'label' => 'user',
                'type' => 'select',
                'options' => $users
            ));
        }

        $manager->addCols(array(
            new Id_AdminManagerCol(
                array('action' => 'view')
            ),
            array(
                'id' => 'type',
                'field' => 'content_type',
                'label' => 'type',
                'action' => 'view',
                'width' => 1
            ),
            new Title_AdminManagerCol(array(
                'field' => 'content_title',
                'action' => 'view'
            )),
            new DateTime_AdminManagerCol(array(
                array('action' => 'view')
            )),
            array(
                'id' => 'user',
                'sortable' => false,
                'action' => 'view',
                'width' => 1
            )
        ));

        $manager->addBatchActions(array(
            'approve',
            'deny'
        ));

        $manager->addRowActions(array(
            new ViewRowAction(),
            'approve',
            'deny',
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_workflow.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_workflow.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

class WorkflowManageModel extends AdminManageModel
{


    function approveRecords(array $ids)
    {
        if ($ids) {
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!$records = FJF_BASE_RICH::getRecords(
                $this->table,
                "FIND_IN_SET(id, 'IDS') ORDER BY id",
                array('IDS' => $ids),
                null,
                "id, content_id, content_type"
            )) {
                $this->addMessage("Approve: Record(s) not found.", true);
            } else {
                $approved = array();
                foreach ($records as $record) {
                    if ($record->content_type == "users") {
                        $userInfo = FJF_BASE_RICH::getRecordBy("users", $record->content_id);
                        if ($userInfo) {
                            $userInfo->status = 1;
                            if (FJF_BASE_RICH::saveRecord("users", get_object_vars($userInfo))) {
                                include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
                                MailModel::sendSuccessMessageToNewUser($userInfo);
                                FJF_BASE_RICH::deleteRecords("workflow", "content_id='CONTENT_ID' AND content_type='CONTENT_TYPE'", array(
                                    'CONTENT_ID' => $record->content_id,
                                    'CONTENT_TYPE' => $record->content_type
                                ));
                                $approved[] = $record->id;
                            }
                        }
                    } else {
                        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");
                        $editor = new AdminEditRevisionsModel(array(
                            'table' => $record->content_type,
                            'id' => $record->content_id
                        ));
                        if ($editor->loadRecord() && $editor->approve()) $approved[] = $record->id;
                    }
                }

                if ($approved) {
                    $this->addMessage(
                        "Successfully approved " . $this->numOfRecords(count($approved), count($records)) . "."
                    );
                } else {
                    $this->addMessage("An error occurred while approving record(s).\n", true);
                }
            }
        }

        return true;
    }//approveRecords

}

class WorkflowManager extends AdminManager
{

    function getRows()
    {
        $records = parent::getRows();
        $users = $this->getData('users');
        if ($records && $users) {
            foreach ($records as $record) {
                if (array_key_exists($record->user_id, $users)) {
                    $record->user = $users[$record->user_id];
                }
            }
        }


        $links = $this->getData('links');
        foreach ($records as $record) {
            $record->content_link = str_replace("%id%", $record->content_id, $links[$record->content_type]);
            $record->content_link .= "?revision_id=" . $record->content_revision_id;
        }

        $types = $this->getData('types');
        foreach ($records as $record) {
            $record->content_type = $types[$record->content_type];
        }

        return $records;
    }

}

class ViewRowAction extends Link_Row_AdminManagerAction
{

    function __construct()
    {
        parent::__construct(array('id' => 'view'));
    }

    function html($row)
    {
        return '<a href="' . $row->content_link . '" target="_blank" class="list-action action-view" title="View">View</a>';
    }

}

?>
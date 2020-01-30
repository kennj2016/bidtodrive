<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminEditRevisionsModel extends AdminEditorBase
{

    protected $title_field = null;
    protected $revisions_table = null;
    protected $revision_id = null;
    protected $load_recent_revision = false;

    protected $workflow_content_type = null;
    protected $workflow_tool_url_title = null;

    function __construct($options)
    {
        parent::__construct($options);

        if ($this->table) $this->revisions_table = $this->table . "_revisions";
        $this->revision_id = isset($_GET['revision_id']) ? trim($_GET['revision_id']) : null;
        $this->workflow_content_type = array_key_exists('workflow_content_type', $options) ? $options['workflow_content_type'] : $this->table;
        if (array_key_exists('user', $options)) $this->user = $options['user'];
        if (array_key_exists('workflow_tool_url_title', $options)) $this->workflow_tool_url_title = $options['workflow_tool_url_title'];
        if (array_key_exists('title_field', $options)) $this->title_field = $options['title_field'];
        if (array_key_exists('revision_id', $options)) $this->revision_id = $options['revision_id'];
        if (array_key_exists('load_recent_revision', $options)) $this->load_recent_revision = $options['load_recent_revision'];
        if ($this->load_recent_revision && !$this->revision_id) {
            if ($revisions = $this->get_revisions(null, null, null, 1)) {
                $this->revision_id = $revisions[0]->revision_id;
            }
        }
    }

    function saveRecord()
    {
        return $this->saveForLater();
    }

    function saveForLater()
    {
        $this->recordUpdated();
        $this->recordApproved(false);
        $this->revisionTag();
        $this->revisionStatus();
        $this->clearAutosave();
        return $this->save();
    }

    function submitForApproval()
    {
        $this->recordUpdated();
        $this->recordApproved(false);
        $this->revisionTag('pending');
        $this->revisionStatus(true);
        $this->clearAutosave();
        return $this->save();
    }

    function saveAndPublish()
    {
        $this->recordUpdated();
        $this->recordApproved();
        $this->revisionTag();
        $this->revisionStatus(true);
        $this->clearAutosave();
        return $this->save();
    }

    function approve()
    {
        $this->recordApproved();
        $this->revisionTag();
        $this->revisionStatus(true);
        return $this->save();
    }

    function autosave()
    {
        $this->recordUpdated();
        $this->recordApproved(false);
        $this->revisionTag('autosave');
        $this->revisionStatus();
        if ($this->save()) {
            if ($revisions = $this->getRevisions($this->record->revision_id)) return $revisions[0];
        }
        return false;
    }

    function get_revisions($_where = null, $_params = null, $order = null, $limit = null)
    {
        $recordId = isset($this->record->id) ? $this->record->id : $this->id;
        $params = array(
            'ID_VAL' => $recordId,
            'UPDATED_BY' => $this->user->id
        );
        if ($_params) $params = array_merge($params, $_params);
        $where = "";
        $where .= "id='ID_VAL'";
        $where .= " AND IF(revision_tag <=> 'autosave', updated_by='UPDATED_BY', TRUE)";
        if ($_where) $where .= " AND (" . $_where . ")";
        if (!$order) $order = "revision_id DESC";
        $where .= " ORDER BY " . $order;
        if ($limit) $where .= " LIMIT " . $limit;
        return $recordId ? FJF_BASE_RICH::getRecords(
            $this->revisions_table, $where, $params, null,
            "revision_id, revision_status, datetime_create, created_by, datetime_update, updated_by"
        ) : null;
    }

    function getRevisions($id = null)
    {
        $where = null;
        $params = null;
        if ($id) {
            $where = "revision_id='REVISION_ID'";
            $params = array('REVISION_ID' => $id);
        }

        if ($revisions = $this->get_revisions($where, $params)) {
            $userIds = array();
            foreach ($revisions as $revision) {
                $userIds[] = $revision->updated_by ? $revision->updated_by : $revision->created_by;
                $revision->revision_datetime = $revision->datetime_update ? $revision->datetime_update : $revision->datetime_create;
            }
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
            if ($users = FJF_BASE_RICH::getRecords(
                "users",
                "id IN ('" . implode("', '", array_unique($userIds)) . "')",
                null,
                null,
                "id, name"
            )) {
                foreach ($revisions as $revision) {
                    if ($userId = $revision->updated_by ? $revision->updated_by : $revision->created_by) {
                        if (array_key_exists($userId, $users)) {
                            $revision->revision_author_name = $users[$userId]->name;
                        }
                    }
                }
            }
        }
        return $revisions ? $revisions : array();
    }

    protected function clearAutosave()
    {
        FJF_BASE_RICH::deleteRecords(
            $this->revisions_table,
            "id='ID_VAL' AND updated_by='UPDATED_BY' AND revision_tag='autosave'",
            array(
                'ID_VAL' => $this->id,
                'UPDATED_BY' => $this->user->id
            )
        );
    }

    protected function getRecord()
    {
        $where = "id='ID_VAL'";
        $params = array('ID_VAL' => $this->id);
        if ($this->revision_id) {
            $where .= " AND revision_id='REVISION_ID'";
            $params['REVISION_ID'] = $this->revision_id;
        } else {
            $where .= " AND revision_status=1";
        }
        $where .= " ORDER BY revision_id DESC LIMIT 1";
        if (!$revision = FJF_BASE_RICH::getRecord($this->revisions_table, $where, $params)) return false;
        if (!$record = FJF_BASE_RICH::getRecords(
            $this->table,
            "id='ID_VAL' LIMIT 1",
            array('ID_VAL' => $this->id),
            true
        )) return false;
        foreach (array("status", "on_home", "position") as $field) {
            if (isset($record->$field)) $revision->$field = $record->$field;
        }
        return $revision;
    }

    protected function newRecord()
    {
        return (object)array(
            'id' => null,
            'status' => 1,
            'approved' => 0,
            'datetime_create' => date("Y-m-d H:i:s"),
            'created_by' => $this->user->id
        );
    }

    protected function save()
    {
        if ($this->record->approved || !$this->id) {
            $record = array_diff_key(
                get_object_vars($this->record),
                array_flip(array('revision_id', 'revision_status', 'revision_tag'))
            );
            if (isset($record['_admin_creators'])) unset($record['_admin_creators']);

            if (isset($record['position'])) unset($record['position']);
            if ($this->positions && $this->isPositionsRelationsChanged()) {
                $record['position'] = 0;
            }

            if (!$result = FJF_BASE_RICH::saveRecord($this->table, $record)) return false;
            if ($this->positions) $this->onSaveUpdatePositions();
            if (!$this->id) {
                $this->record->id = $result;
                $this->revisionStatus(true);
            }
            if ($this->record->approved) {
                FJF_BASE_RICH::deleteRecords("workflow", "content_id='CONTENT_ID' AND content_type='CONTENT_TYPE'", array(
                    'CONTENT_ID' => $this->record->id,
                    'CONTENT_TYPE' => $this->workflow_content_type
                ));
            }
        }

        if ($this->record->revision_status) FJF_BASE_RICH::updateRecords(
            $this->revisions_table,
            "revision_status=0",
            "id='ID_VAL'",
            array('ID_VAL' => $this->record->id)
        );
        $record = get_object_vars($this->record);
        if (isset($record['_admin_creators'])) unset($record['_admin_creators']);
        if ($result = FJF_BASE_RICH::saveRecord($this->revisions_table, $record, "revision_id")) {
            $this->record->revision_id = $result;

            if ($this->record->revision_tag == 'pending') {

                if (isset($this->record->title)) $title = $this->record->title;
                elseif (isset($this->record->name)) $title = $this->record->name;
                elseif ($this->title_field && isset($this->record->{$this->title_field})) $title = $this->record->{$this->title_field};
                else {
                    $record = array_values(get_object_vars($this->record));
                    $title = $record[3];
                }

                if (FJF_BASE_RICH::saveRecord("workflow", array(
                    'content_id' => $this->record->id,
                    'content_revision_id' => $this->record->revision_id,
                    'content_title' => $title,
                    'content_type' => $this->workflow_content_type,
                    'user_id' => SessionModel::user()->id,
                    'datetime' => date("Y-m-d H:i:s")
                ))) {

                    $var = FJF_BASE_RICH::getRecords("site_vars", "name='workflow_notification_email' AND value<>'' LIMIT 1", null, true, "value");
                    if ($var) {
                        $emails = array_map("trim", explode(",", $var->value));

                        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["resources_path"] . "/PHPMailer/class.phpmailer.php");
                        $mail = new PHPMailer();
                        $mail->SetFrom(SessionModel::user()->email, SessionModel::user()->name);
                        $mail->Subject = 'New Workflow Item';

                        $link = "http://" . $_SERVER["SERVER_NAME"] . "/admin/" . $this->table . "/" . $this->record->id . "/";
                        $link2 = "http://" . $_SERVER["SERVER_NAME"] . "/admin/workflow/";

                        $mail->MsgHTML(
                            'View Submited Item: <a href="' . $link . '">' . $link . '</a><br /><br />' .
                            'View Workflow Items: <a href="' . $link2 . '">' . $link2 . '</a>'
                        );

                        foreach ($emails as $email) {
                            $mail->ClearAddresses();
                            $mail->AddAddress($email);
                            $mail->Send();
                        }

                    }

                }

            }

        }

        return true;
    }

    protected function recordApproved($approved = true)
    {
        $this->record->approved = $approved ? 1 : 0;
        $this->record->datetime_approve = $approved ? date("Y-m-d H:i:s") : null;
        $this->record->approved_by = $approved ? $this->user->id : null;
        $this->record->_admin_creators['approved_by'] = $approved ? $this->user->name : null;
    }

    protected function recordUpdated()
    {
        if ($this->id) {
            $this->record->datetime_update = date("Y-m-d H:i:s");
            $this->record->updated_by = $this->user->id;
            $this->record->_admin_creators['updated_by'] = $this->user->name;
            unset($this->record->revision_id);
        }
    }

    protected function revisionTag($tag = null)
    {
        $this->record->revision_tag = $tag;
    }

    protected function revisionStatus($status = false)
    {
        $this->record->revision_status = $status ? 1 : 0;
    }

}

?>

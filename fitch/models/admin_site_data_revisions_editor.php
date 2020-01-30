<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminSiteDataRevisionsEditor extends AdminEditRevisionsModel
{

    protected $type = null;
    protected $clone_fields = array(
        'revision_id',
        'revision_status',
        'revision_tag',
        '_admin_creators',
        'approved',
        'datetime_update',
        'datetime_create',
        'datetime_approve'
    );

    function __construct($type, $id = null)
    {
        $options = array('table' => 'site_data');
        if ($id) $options['id'] = $id;
        parent::__construct($options);
        $this->type = $type;
    }

    function get_revisions($_where = null, $_params = null, $order = null, $limit = null)
    {
        $recordId = isset($this->record->name) ? $this->record->name : $this->id;
        $params = array(
            'TYPE_VAL' => $this->type,
            'NAME_VAL' => $recordId,
            'UPDATED_BY' => $this->user->id
        );
        if ($_params) $params = array_merge($params, $_params);
        $where = "";
        $where .= "type='TYPE_VAL' AND name='NAME_VAL'";
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

    protected function clearAutosave()
    {
        FJF_BASE_RICH::deleteRecords(
            $this->revisions_table,
            "type='TYPE_VAL' AND name='NAME_VAL' AND updated_by='UPDATED_BY' AND revision_tag='autosave'",
            array(
                'TYPE_VAL' => $this->type,
                'NAME_VAL' => $this->id,
                'UPDATED_BY' => $this->user->id
            )
        );
    }

    protected function getRecord()
    {
        $where = "type='TYPE_VAL' AND name='NAME_VAL'";
        $params = array('TYPE_VAL' => $this->type, 'NAME_VAL' => $this->id);
        if ($this->revision_id) {
            $where .= " AND revision_id='REVISION_ID'";
            $params['REVISION_ID'] = $this->revision_id;
        } else {
            $where .= " AND revision_status=1";
        }
        $where .= " ORDER BY revision_id DESC LIMIT 1";
        $revision = FJF_BASE_RICH::getRecord($this->revisions_table, $where, $params);
        $record = FJF_BASE_RICH::getRecords(
            $this->table,
            "type='TYPE_VAL' AND name='NAME_VAL' LIMIT 1",
            array('TYPE_VAL' => $this->type, 'NAME_VAL' => $this->id),
            true
        );
        if (!$revision) $revision = $record ? $record : $this->newRecord();
        return $revision;
    }

    protected function newRecord()
    {
        return (object)array(
            'id' => null,
            'type' => $this->type,
            'name' => $this->id,
            'approved' => 0,
            'datetime_create' => date("Y-m-d H:i:s"),
            'created_by' => $this->user->id,
            'data' => null
        );
    }

    function loadRecord()
    {
        parent::loadRecord();
        $this->record->data = $this->record->data ? json_decode($this->record->data) : new stdClass;
        foreach ($this->clone_fields as $field) {
            if (isset($this->record->{$field})) {
                $this->record->data->{$field} = $this->record->{$field};
            }
        }
        return $this->record->data;
    }

    function clearRecord()
    {
        foreach ($this->record->data as $key => $value) unset($this->record->data->$key);
    }

    function save()
    {
        foreach ($this->clone_fields as $field) {
            if (isset($this->record->{$field})) {
                unset($this->record->data->{$field});
            }
        }
        $this->record->data = json_encode($this->record->data);

        if ($this->record->approved || !$this->id) {
            $record = array_diff_key(
                get_object_vars($this->record),
                array_flip(array('revision_id', 'revision_status', 'revision_tag'))
            );
            if (isset($record['_admin_creators'])) unset($record['_admin_creators']);

            if (!$result = FJF_BASE_RICH::saveRecord($this->table, $record)) return false;
            if (!$this->id) {
                $this->record->id = $result;
                $this->revisionStatus(true);
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
        }

        $this->record->data = json_decode($this->record->data);
        foreach ($this->clone_fields as $field) {
            if (isset($this->record->{$field})) {
                $this->record->data->{$field} = $this->record->{$field};
            }
        }

        return true;
    }

    function validate(array $fields = array(), $record = null)
    {
        if (!$record) $record = $this->record->data;
        return parent::validate($fields, $record);
    }

}

?>
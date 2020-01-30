<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminSiteDataEditor extends AdminEditModel
{

    protected $type = null;
    protected $clone_fields = array(
        '_admin_creators',
        'datetime_update',
        'datetime_create'
    );

    function __construct($type, $id = null)
    {
        $options = array('table' => 'site_data');
        if ($id) $options['id'] = $id;
        parent::__construct($options);
        $this->type = $type;
    }

    protected function getRecord()
    {
        $record = FJF_BASE_RICH::getRecord(
            $this->table,
            "type='TYPE_VAL' AND name='NAME_VAL'",
            array('TYPE_VAL' => $this->type, 'NAME_VAL' => $this->id),
            true
        );
        if (!$record) $record = $this->newRecord();
        return $record;
    }

    protected function newRecord()
    {
        return (object)array(
            'id' => null,
            'type' => $this->type,
            'name' => $this->id,
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

    function saveRecord()
    {
        foreach ($this->clone_fields as $field) {
            if (isset($this->record->{$field})) {
                unset($this->record->data->{$field});
            }
        }
        $this->record->data = json_encode($this->record->data);
        $result = parent::saveRecord();
        $this->record->data = json_decode($this->record->data);
        foreach ($this->clone_fields as $field) {
            if (isset($this->record->{$field})) {
                $this->record->data->{$field} = $this->record->{$field};
            }
        }
        return $result;
    }

    function validate(array $fields = array(), $record = null)
    {
        if (!$record) $record = $this->record->data;
        return parent::validate($fields, $record);
    }

    function clearRecord()
    {
        foreach ($this->record->data as $key => $value) unset($this->record->data->$key);
    }

}

?>
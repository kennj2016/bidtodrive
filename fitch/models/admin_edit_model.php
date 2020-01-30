<?php

class AdminEditModel extends AdminEditorBase
{

    function saveRecord()
    {
        if ($this->id) {
            $this->record->datetime_update = date("Y-m-d H:i:s");
            $this->record->updated_by = $this->user->id;
            $this->record->_admin_creators['updated_by'] = $this->user->name;
        }

        $record = get_object_vars($this->record);
        if (isset($record['_admin_creators'])) unset($record['_admin_creators']);

        if (isset($record['position'])) unset($record['position']);
        if ($this->positions && $this->isPositionsRelationsChanged()) {
            $record['position'] = 0;
        }

        if (!$result = FJF_BASE_RICH::saveRecord($this->table, $record)) return false;
        if ($this->positions) $this->onSaveUpdatePositions();
        if (!$this->id) {
            $this->record->id = $result;
        }
        return true;
    }

    protected function getRecord()
    {
        return FJF_BASE_RICH::getRecordBy($this->table, $this->id);
    }

    protected function newRecord()
    {
        return (object)array(
            'id' => null,
            'status' => 1,
            'datetime_create' => date("Y-m-d H:i:s"),
            'created_by' => isset($this->user->id) && $this->user->id ? $this->user->id : 1
        );
    }

}

abstract class AdminEditorBase
{
    protected $user = null;
    protected $table = null;
    protected $id = null;
    protected $record = null;
    protected $record_orig = null;
    protected $positions = false;
    protected $positions_condition = "TRUE";
    protected $positions_relations = null;

    function __construct($options)
    {
        $this->user = SessionModel::user();
        $this->table = $options['table'] ? $options['table'] : null;
        $this->id = isset($_GET['id']) ? trim($_GET['id']) : null;
        if (array_key_exists('id', $options)) $this->id = $options['id'];
        if (array_key_exists('positions', $options)) $this->positions = $options['positions'];
    }

    function urlTitle($str)
    {
        return strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $str), "-"));
    }

    function autofillMetadata($titleField = null)
    {
        if (isset($_POST['url_title']) || $titleField) {
            $this->record->url_title = isset($_POST['url_title']) ? trim($_POST['url_title']) : '';
            if (!$this->record->url_title && $titleField) $this->record->url_title = $this->record->$titleField;
            if ($this->record->url_title) $this->record->url_title = $this->urlTitle($this->record->url_title);
        }
        $this->record->meta_title = isset($_POST['meta_title']) ? trim($_POST['meta_title']) : '';
        $this->record->meta_keywords = isset($_POST['meta_keywords']) ? trim($_POST['meta_keywords']) : '';
        $this->record->meta_description = isset($_POST['meta_description']) ? trim($_POST['meta_description']) : '';
    }

    function loadRecord()
    {
        $this->record = $this->id ? $this->getRecord() : $this->newRecord();

        if ($this->record) {
            $this->record_orig = clone $this->record;
            $this->record->_admin_creators = array(
                'created_by' => null,
                'updated_by' => null,
                'approved_by' => null
            );

            $adminsIds = array();
            foreach ($this->record->_admin_creators as $field => $name) {
                if (isset($this->record->$field) && $this->record->$field) $adminsIds[$field] = $this->record->$field;
            }

            if ($adminsIds) {
                $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
                if ($admins = FJF_BASE_RICH::getRecords(
                    "users",
                    "id IN (" . implode(",", $adminsIds) . ")",
                    null,
                    null,
                    "id, name"
                )) {
                    foreach ($adminsIds as $field => $adminId) {
                        if (array_key_exists($adminId, $admins)) $this->record->_admin_creators[$field] = $admins[$adminId]->name;
                    }
                }
            }
        }

        return $this->record;
    }

    abstract function saveRecord();

    abstract protected function getRecord();

    abstract protected function newRecord();

    static function matchFormat($value, $format)
    {
        if ($format == 'email') $format = "/^.+\\@.+\\..+$/";
        else if ($format == 'zip') $format = "/^\\d{5}$/";
        else if ($format == 'phone') $format = "/^\\(\\d{3}\\) \\d{3}\\-\\d{4}$/";
        else if ($format == 'url') $format = "/^([a-z\\d]+:\\/\\/[a-z\\d\\-\\.]+[a-z])?(\\/.*|)$/i";
        else if ($format == 'int') $format = "/^\\-?\\d+$/i";
        else if ($format == 'float') $format = "/^\\-?\\d+(\\.\\d+)?$/i";
        else if ($format == 'usint') $format = "/^\\d+$/i";
        else if ($format == 'usfloat') $format = "/^\\d+(\\.\\d+)?$/i";
        return !!preg_match($format, $value);
    }

    static function formatHint($label, $options)
    {
        $hint = null;
        $format = null;
        if (isset($options['format_hint'])) $hint = $options['format_hint'];
        else {
            if ($options['format'] == 'url') $hint = $label . ' should be valid URL (ex. http://domain.com/page).';
            else {
                if ($options['format'] == 'phone') $format = "(XXX) XXX-XXXX";
                if ($format) $hint = 'Valid format is "' . $format . '".';
            }
        }
        return $hint ? ' ' . $hint : '';
    }

    function validate(array $fields = array(), $record = null)
    {
        if (!$record) $record = $this->record;

        $messages = array();
        foreach ($fields as $field => $options) {

            $value = isset($record->{$field}) ? $record->{$field} : null;
            $label = "`" . (isset($options['label']) ? $options['label'] : ucwords(str_replace("_", " ", $field))) . "`";

            if ($value != '') {

                if (isset($options['min']) && strlen($value) < $options['min']) {
                    $messages[] = $label . ' must contain at minimum ' . $options['min'] . ' characters.';
                } else if (isset($options['max']) && strlen($value) > $options['max']) {
                    $messages[] = $label . ' must contain at maximum ' . $options['max'] . ' characters.';
                } else if (isset($options['format']) && !self::matchFormat($value, $options['format'])) {
                    $messages[] = 'Invalid ' . $label . ' format.' . self::formatHint($label, $options);
                }
            } else if (isset($options['required']) && $options['required']) {
                $messages[] = $label . ' is missing.';
            }

        }

        return $messages;
    }

    function setPositionsRelations($fieldName)
    {
        $this->positions_relations = $fieldName;
    }

    function isPositionsRelationsChanged()
    {
        return $this->id && $this->positions_relations && $this->record_orig->{$this->positions_relations} != $this->record->{$this->positions_relations};
    }

    function onSaveUpdatePositions()
    {
        $isPositionsRelationsChanged = $this->isPositionsRelationsChanged();
        if ($this->id && !$isPositionsRelationsChanged) return;

        if ($isPositionsRelationsChanged) {
            $where = "position>'POSITION_VALUE' AND " . $this->positions_relations . "='POSITIONS_RELATIONS'";
            $params = array(
                'POSITION_VALUE' => $this->record_orig->position,
                'POSITIONS_RELATIONS' => $this->record_orig->{$this->positions_relations}
            );
            FJF_BASE_RICH::updateRecords($this->table, "position=position-1", $where . " ORDER BY position", $params);
        }

        if ($this->positions_relations) {
            $where = $this->positions_relations . "='POSITIONS_RELATIONS'";
            $params = array('POSITIONS_RELATIONS' => $this->record->{$this->positions_relations});
        } else {
            $where = "TRUE";
            $params = null;
        }
        FJF_BASE_RICH::updateRecords($this->table, "position=position+1", $where . " ORDER BY position DESC", $params);
    }

}

class AdminAutocompleteField
{

    protected $name = '';
    protected $values_table = '';
    protected $values = array();
    protected $value = '';
    protected $multiple = false;
    protected $allow_new_value = false;
    protected $new_value_editor = 'AdminEditModel';

    function __construct($name, $values, $multiple = false)
    {
        $this->name = $name;
        if (is_string($values)) {
            $this->values_table = $values;
            $this->values = FJF_BASE_RICH::getList($this->values_table);
        } else {
            $this->values = $values ? $values : array();
        }
        $this->multiple = $multiple;
    }

    function allowNewValues($allowNewValue)
    {
        $this->allow_new_value = $allowNewValue;
    }

    function newValue($input)
    {
        if (is_object($this->allow_new_value)) $editor = $this->allow_new_value;
        else $editor = new AdminEditModel(array(
            'table' => is_string($this->allow_new_value) ? $this->allow_new_value : $this->values_table,
            'id' => null
        ));
        $record = $editor->loadRecord();
        $record->title = $input;
        return $editor->saveRecord() ? $record->id : false;
    }

    function getValue($input = null, $forceIntegers = true)
    {
        if ($input === null && isset($_REQUEST[$this->name])) {
            if ($this->multiple) {
                $input = is_array($_REQUEST[$this->name]) ? array_map('trim', $_REQUEST[$this->name]) : [];
            } else {
                $input = [trim($_REQUEST[$this->name])] ?: '';
            }
            $value = !$this->multiple && is_array($input) ? reset($input) : $input;
            if ($forceIntegers)
                $value = is_array($value) ? (count($value) ? implode(',', array_map('intval', $value)) : '') : (int)$value;
            return $value;
        }
    }

    function toValue($label)
    {
        return $this->values ? array_search(strtolower($label), array_map("strtolower", $this->values)) : false;
    }

    function toLabel($value)
    {
        return $this->values && array_key_exists($value, $this->values) ? $this->values[$value] : "";
    }

    function setValue($value)
    {
        $this->value = is_array($value) ? $value : explode(',', $value);
    }

    function getValues()
    {
        return $this->values ? array_values($this->values) : array();
    }

    public function htmlInput($name = null, $value = null)
    {
        $name = $name ?: $this->name;
        $value = $value ?: $this->value;
        $value = is_array($value) ? $value : (strlen($value) ? explode(',', $value) : []);

        $html = "<select name='" . (htmlentities($name, ENT_QUOTES)) . ($this->multiple ? '[]' : '') . "' class='select-autocomplete'" . ($this->multiple ? ' multiple' : '') . ">";
        if (!$this->multiple)
            $html .= '<option value="">select</option>';
        foreach ($this->values as $key => $singleValue) {
            $html .= '<option' . (in_array($key, $value) ? ' selected' : '') . ' value="' . htmlentities($key) . '">' . htmlentities($singleValue) . '</option>';
        }
        $html .= "</select>";
        return $html;
    }

}

class AdminAutocompleteFieldEx extends AdminAutocompleteField
{

    function toValue($label)
    {
        if ($this->values) foreach ($this->values as $v) {
            if ($label == $v->label) return $v->value;
        }
        return false;
    }

    function toLabel($value)
    {
        if ($this->values) foreach ($this->values as $v) {
            if ($value == $v->value) return $v->label;
        }
        return '';
    }

    function getValues()
    {
        return $this->values;
    }

}

?>
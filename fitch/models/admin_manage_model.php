<?php

class AdminManageModel
{

    protected $table;
    protected $messages = array();

    function __construct($table)
    {
        $this->table = $table;
    }

    protected $has_positions = false;

    function hasPositions($val = true)
    {
        $this->has_positions = $val;
    }

    protected $positions_relations = null;

    function setPositionsRelations($fieldName)
    {
        $this->positions_relations = $fieldName;
    }

    protected $has_readonly = false;

    function hasReadonly($val = true)
    {
        $this->has_readonly = $val;
    }

    protected $has_revisions = false;

    function hasRevisions($val = true)
    {
        $this->has_revisions = $val;
    }

    function additionalCondition()
    {
        return "";
    }

    function additionalConditionParams()
    {
        return array();
    }

    function deleteRecords(array $ids)
    {

        if ($ids) {
            if (is_array($ids)) $ids = implode(',', $ids);

            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
            if (!$records = FJF_BASE_RICH::getRecords(
                $this->table,
                "FIND_IN_SET(id, 'IDS') " . ($this->has_readonly ? ' AND readonly = 0' : '') . $this->additionalCondition()
                . " ORDER BY " . ($this->has_positions ? "position" : "id"),
                array('IDS' => $ids) + $this->additionalConditionParams(),
                null,
                "id" . ($this->has_positions ? ', position' : '') . ($this->positions_relations ? ', ' . $this->positions_relations : '')
            )) {
                $this->addMessage("Delete: Record(s) not found.", true);
            } elseif (!FJF_BASE_RICH::deleteRecords(
                $this->table,
                "FIND_IN_SET(id, 'IDS')",
                array('IDS' => implode(',', array_keys($records)))
            )) {
                $this->addMessage(
                    "An error occurred while deleting record(s) from DB.", true
                );
            } else {
                $this->addMessage(
                    "Successfully deleted " . $this->numOfRecords(FJF_BASE::db_affected_rows(), count($records)) . "."
                );
                if ($this->has_revisions) {
                    FJF_BASE_RICH::deleteRecords(
                        $this->table . "_revisions",
                        "FIND_IN_SET(id, 'IDS')",
                        array('IDS' => implode(',', array_keys($records)))
                    );
                    FJF_BASE_RICH::deleteRecords("workflow", "FIND_IN_SET(content_id, 'CONTENT_IDS') AND content_type='CONTENT_TYPE'", array(
                        'CONTENT_IDS' => implode(',', array_keys($records)),
                        'CONTENT_TYPE' => $this->table
                    ));
                }
                if ($this->has_positions) {
                    foreach ($records as $i => $record) {

                        foreach ($records as $r) {
                            if ($r->position > $record->position) {
                                if (!$this->positions_relations || $r->{$this->positions_relations} == $record->{$this->positions_relations}) {
                                    $r->position--;
                                }
                            }
                        }

                        $where = "position>'POSITION_VALUE'";
                        $params = array('POSITION_VALUE' => $record->position);
                        if ($this->positions_relations) {
                            $where .= " AND " . $this->positions_relations . "='POSITIONS_RELATIONS'";
                            $params['POSITIONS_RELATIONS'] = $record->{$this->positions_relations};
                        }
                        FJF_BASE_RICH::updateRecords(
                            $this->table,
                            "position=position-1",
                            $where . $this->additionalCondition() . " ORDER BY position",
                            $params + $this->additionalConditionParams()
                        );

                    }
                }
            }
        }

        return true;
    }//deleteRecords

    function toggleRecords(array $ids, $field = 'status')
    {

        if ($ids) {
            if (is_array($ids)) $ids = implode(',', $ids);

            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
            if (!$records = FJF_BASE_RICH::getRecords(
                $this->table,
                "FIND_IN_SET(id, 'IDS')" . $this->additionalCondition(),
                array('IDS' => $ids) + $this->additionalConditionParams()
            )) {
                $this->addMessage("Toggle: Record(s) not found.", true);
            } elseif (!FJF_BASE_RICH::updateRecords(
                $this->table,
                $field . "=IF(" . $field . "=1, 0, 1)",
                "FIND_IN_SET(id, 'IDS')",
                array('IDS' => implode(',', array_keys($records)))
            )) {
                $this->addMessage(
                    "Toggle: An error occurred while updating record(s).", true
                );
            } else {
                $this->addMessage(
                    "Toggle: Successfully updated " . $this->numOfRecords(FJF_BASE::db_affected_rows(), count($records)) . "."
                );
            }
        }

        return true;
    }//toggleRecords

    function duplicateRecords($ids, array $set = null, array $unset = null, $changeTitle = null, $changeTitleUrl = null)
    {

        if ($ids) {
            if (is_array($ids)) $ids = implode(',', $ids);

            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
            if (!$records = FJF_BASE_RICH::getRecords(
                $this->table,
                "FIND_IN_SET(id, 'IDS')" . $this->additionalCondition(),
                array('IDS' => $ids) + $this->additionalConditionParams()
            )) {
                $this->addMessage("Duplicate: Record(s) not found.", true);
            } else {
                $counter = 0;

                foreach ($records as $record) {
                    $record = get_object_vars($record);

                    if (!$set) $set = array();
                    $set['status'] = 1; //recently they wanted to make it active by default
                    $set['datetime_create'] = date("Y-m-d H:i:s");
                    $set['created_by'] = SessionModel::sessionUser()->id;
                    $record = array_merge($record, $set);

                    if (!$unset) $unset = array();
                    $unset[] = 'id';
                    $unset[] = 'datetime_update';
                    $unset[] = 'updated_by';
                    if (!SessionModel::isSuperAdmin()) {
                        $unset[] = 'datetime_approve';
                        $unset[] = 'approved_by';
                        $unset[] = 'approved';
                    }
                    $unset[] = 'position';
                    $unset[] = 'readonly';
                    $record = array_diff_key($record, array_flip($unset));

                    if ($changeTitle && isset($record[$changeTitle])) {
                        $record[$changeTitle] = preg_replace("/\s?\(Copy\)$/", "", $record[$changeTitle]);
                        $record[$changeTitle] .= ($record[$changeTitle] ? " " : "") . "(Copy)";
                    }

                    if ($changeTitleUrl && isset($record[$changeTitleUrl])) {
                        $record[$changeTitleUrl] = FJF_BASE_RICH::generateURL(
                            $record[$changeTitleUrl], 0, $this->table, $changeTitleUrl
                        );
                    }

                    if ($result = FJF_BASE_RICH::saveRecord($this->table, $record)) {
                        $record['id'] = $result;
                        if ($this->has_revisions) {
                            FJF_BASE_RICH::saveRecord(
                                $this->table . "_revisions",
                                $record + array('revision_status' => 1),
                                "revision_id"
                            );
                        }
                        if ($this->has_positions) {
                            if ($this->positions_relations) {
                                $where = $this->positions_relations . "='POSITIONS_RELATIONS'";
                                $params = array('POSITIONS_RELATIONS' => $record[$this->positions_relations]);
                            } else {
                                $where = "TRUE";
                                $params = array();
                            }
                            FJF_BASE_RICH::updateRecords(
                                $this->table,
                                "position=position+1",
                                $where . $this->additionalCondition() . " ORDER BY position DESC",
                                $params + $this->additionalConditionParams()
                            );
                        }
                        $counter++;
                    }
                }

                if (!$counter) {
                    $this->addMessage("An error occurred while duplicating record(s).\n", true);
                } else {
                    $this->addMessage(
                        "Successfully duplicated " . $this->numOfRecords($counter, count($records)) . "."
                    );
                }
            }

        }

        return true;
    }//duplicateRecords

    function switchPositions($from, $to)
    {
        $result = null;

        if (!$from || !$to) {
            $this->addMessage(
                "Invalid input.", true
            );
        } elseif ($from == $to) {
            $this->addMessage(
                "Positions not changed."
            );
        } else {
            $params = array('POS_FROM' => $from, 'POS_TO' => $to) + $this->additionalConditionParams();

            $recordsNotFound = false;
            if ($this->positions_relations) {
                $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
                $records = FJF_BASE_RICH::getRecords($this->table, "id IN ('POS_FROM', 'POS_TO')" . $this->additionalCondition(), $params, null, "id, position, " . $this->positions_relations);
                if (count($records) != 2) $recordsNotFound = true;
                else {
                    $positionsRelations = $records[$from]->{$this->positions_relations};
                    $from = $records[$from]->position;
                    $to = $records[$to]->position;
                    $params = array('POS_FROM' => $from, 'POS_TO' => $to) + $this->additionalConditionParams();
                }
            } elseif (FJF_BASE_RICH::countFrom($this->table, "position IN ('POS_FROM', 'POS_TO')" . $this->additionalCondition(), $params) != 2) {
                $recordsNotFound = true;
            }

            if ($recordsNotFound) {
                $this->addMessage("Change Positions: Record(s) not found.", true);
            } else {

                if ($this->positions_relations) {
                    $params['POSITIONS_RELATIONS'] = $positionsRelations;
                    $cond = $this->positions_relations . "='POSITIONS_RELATIONS'";
                } else {
                    $cond = "TRUE";
                }

                $cond .= $this->additionalCondition();

                $result = FJF_BASE_RICH::updateRecords($this->table, "position=0", $cond . " AND position='POS_FROM'", $params);
                if ($result) {
                    if ($from < $to) {
                        $result = FJF_BASE_RICH::updateRecords($this->table, "position=position-1", $cond . " AND position > 'POS_FROM' AND position <= 'POS_TO' ORDER BY position ASC", $params);
                    } elseif ($from > $to) {
                        $result = FJF_BASE_RICH::updateRecords($this->table, "position=position+1", $cond . " AND position >= 'POS_TO' AND position < 'POS_FROM' ORDER BY position DESC", $params);
                    }
                    if ($result) {
                        $result = FJF_BASE_RICH::updateRecords($this->table, "position='POS_TO'", $cond . " AND position=0", $params);
                    }
                }

                if (!$result) {
                    $this->addMessage(
                        "An error occurred while updating record(s) in DB.", true
                    );
                } else {
                    $this->addMessage(
                        "Successfully update positions."
                    );
                }

            }
        }

        return $result;
    }//switchPositions

    function registerPostAction($action, $var = null)
    {
        if (!$var) $var = "ids";

        $action = isset($_POST['action']) && $action == $_POST['action'] ? $action : null;
        if ($action == 'delete') {
            if (isset($_POST[$var]) && is_array($_POST[$var])) $this->deleteRecords($_POST[$var]);
        } elseif ($action == 'onhome') {
            if (isset($_POST[$var]) && is_array($_POST[$var])) $this->toggleRecords(
                $_POST[$var],
                func_num_args() > 2 ? func_get_arg(2) : 'on_home'
            );
        } elseif ($action == 'toggle') {
            if (isset($_POST[$var]) && is_array($_POST[$var])) $this->toggleRecords(
                $_POST[$var],
                func_num_args() > 2 ? func_get_arg(2) : 'status'
            );
        } elseif ($action == 'duplicate') {
            if (isset($_POST[$var]) && is_array($_POST[$var])) $this->duplicateRecords(
                $_POST[$var],
                func_get_arg(2),
                func_get_arg(3),
                func_get_arg(4),
                func_get_arg(5)
            );
        }

    }//registerPostAction

    function numOfRecords($success, $total)
    {
        $message = ($success == $total ? $total : $success . " out of " . $total) . " record" . ($total > 1 ? "s" : "");
        return $message;
    }//numOfRecords

    function addMessage($message, $error = false)
    {
        $this->messages[] = array(
            'message' => (string)$message,
            'error' => (bool)$error
        );
    }//addMessage

    function getMessages()
    {
        return $this->messages;
    }//getMessages

}

class AdminManager
{

    public $common_actions = array();
    public $batch_actions = array();
    public $row_actions = array();
    public $cols = array();
    public $rows = array();
    public $filters = array();

    protected $destinations_classes = array(
        'common_actions' => 'Common_AdminManagerAction',
        'batch_actions' => 'Batch_AdminManagerAction',
        'row_actions' => 'Row_AdminManagerAction',
        'cols' => 'AdminManagerCol',
        'rows' => 'AdminManagerRow',
        'filters' => 'AdminManagerFilter',
    );

    protected $has_positions = false;

    function hasPositions($val = true)
    {
        $this->has_positions = $val;
        if ($this->has_positions) {
            $this->addCol(new Position_AdminManagerCol);
            $this->setOption(array(
                'default_sort' => 'position'
            ));
        }
    }

    protected $positions_relations = null;

    function setPositionsRelations($filter)
    {
        $this->cols['position']->setRelativeFilter($filter);
    }

    function addItem($destination, $data)
    {
        $class = $this->destinations_classes[$destination];
        if (!is_object($data) || !is_a($data, $class)) {
            if (is_string($data) || is_numeric($data)) $data = array('id' => $data);
            $data = new $class($data);
        }
        $data->manager = $this;
        $this->{$destination}[$data->id] = $data;
        return $data;
    }

    function addItems($destination, $arr)
    {
        foreach ($arr as $i => $data) $arr[$i] = $this->addItem($destination, $data);
        return $arr;
    }

    function getItem($destination, $id)
    {
        return isset($this->{$destination}[$id]) ? $this->{$destination}[$id] : null;
    }

    function __call($name, $arguments)
    {
        $method = null;
        $prefix = substr($name, 0, 3);
        if (in_array($prefix, array('add', 'get'))) {
            $n = substr($name, 3);
            foreach ($this->destinations_classes as $destination => $class) {
                $d = str_replace(" ", "", ucwords(str_replace("_", " ", substr($destination, 0, -1))));
                if ($n == $d) $method = 'Item';
                elseif ($n == $d . "s") $method = 'Items';
                if ($method) {
                    array_unshift($arguments, $destination);
                    break;
                }
            }
        }
        if ($method) return call_user_func_array(array($this, $prefix . $method), $arguments);
    }

    public $data = array();

    function setData()
    {
        if (func_num_args() == 1) $this->data = array_merge($this->data, func_get_arg(0));
        else $this->data[func_get_arg(0)] = func_get_arg(1);
    }

    function getData($var)
    {
        return isset($this->data[$var]) ? $this->data[$var] : null;
    }

    public $options = array();

    function setOption()
    {
        if (func_num_args() == 1) $this->options = array_merge($this->options, func_get_arg(0));
        else $this->options[func_get_arg(0)] = func_get_arg(1);
    }

    function getOption($var)
    {
        return isset($this->options[$var]) ? $this->options[$var] : null;
    }

    public $page = 1;
    public $total = 0;
    public $total_pages = 0;
    public $limit = 20;
    public $offset = 0;
    public $sort = null;
    public $order = null;
    public $default_order = 'asc';

    function apply()
    {

        $this->page = isset($_GET['page']) && $_GET['page'] > 1 ? intval($_GET['page']) : 1;

        if ($this->limit && $this->page == 1) {
            $url = parse_url($_SERVER["REQUEST_URI"]);
            $savedQuery = isset($_COOKIE["admin_list_state"][$GLOBALS["REQUEST_CMD"]]) ? $_COOKIE["admin_list_state"][$GLOBALS["REQUEST_CMD"]] : "";
            $newQuery = isset($url["query"]) ? $url["query"] : "";
            if ($newQuery != $savedQuery) {
                if ($newQuery) {
                    setcookie("admin_list_state[" . $GLOBALS["REQUEST_CMD"] . "]", $newQuery, 0, $url["path"]);
                } elseif ($savedQuery) {
                    FJF_BASE::redirect($url["path"] . "?" . $savedQuery);
                }
            }
        }

        $this->total = $this->getTotal();
        if ($this->limit) {
            $this->total_pages = ceil($this->total / $this->limit);
            $this->offset = $this->limit * ($this->page - 1);
        }

        $col = isset($_GET['sort']) && $_GET['sort'] ? $this->getCol($_GET['sort']) : null;
        if ($col && $col->sortable) {
            $order = isset($_GET['order']) ? $_GET['order'] : null;
        } elseif ($col = $this->getOption('default_sort')) {
            $col = $this->getCol($col);
            $order = $this->getOption('default_order');
        }
        if ($col && $col->sortable) {
            $this->sort = $col;
            $this->order = $order == 'desc' ? 'desc' : 'asc';
        }

        if ($this->offset < $this->total) {
            if ($records = $this->getRows()) {
                $this->addRows($records);
            }
        }
    }

    static function generateCSVRow(array $record)
    {
        foreach ($record as $j => $val) $record[$j] = str_replace("\"", "\"\"", $val);
        return "\"" . implode("\";\"", $record) . "\"";
    }

    static function generateCSV(array $records)
    {
        $first = true;
        foreach ($records as $i => $record) {
            if ($first) {
                $first = false;
            } else {
                echo "\n";
            }
            echo self::generateCSVRow($record);
        }
    }

    function rowsToCSV($fields)
    {
        echo self::generateCSVRow(array_merge(array("#"), $fields));
        foreach ($this->rows as $i => $record) {
            $csvRow = array($i);
            foreach ($fields as $field => $title) $csvRow[] = $record->{$field};
            echo "\n" . self::generateCSVRow($csvRow);
        }
    }

    function export($fields, array $options = array())
    {
        $this->limit = 0;
        $this->apply();

        $filename = array_key_exists('filename', $options) ? $options['filename'] : null;

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . ($filename ? $filename : 'export-' . time()) . '.csv"');
        $this->rowsToCSV($fields);
        exit;
    }

    function getTotal()
    {
        return FJF_BASE_RICH::countFrom($this->getOption('table'), $this->sqlWhere(), $this->sqlParams());
    }

    function getRows()
    {
        $sqlWhere = $this->sqlWhere();
        if (!$sqlWhere) $sqlWhere = "TRUE";
        return FJF_BASE_RICH::getRecords(
            $this->getOption('table'),
            $sqlWhere . $this->sqlOrder() . $this->sqlLimit(),
            $this->sqlParams()
        );
    }

    function sqlWhere()
    {
        $where = array();
        foreach ($this->filters as $filter) {
            if ($cond = $filter->sqlWhere()) $where[] = $cond;
        }
        return $where ? "(" . implode(") AND (", $where) . ")" : null;
    }

    function sqlLimit()
    {
        return $this->limit ? " LIMIT " . $this->offset . "," . $this->limit : "";
    }

    function sqlOrder()
    {
        return $this->sort ? " ORDER BY " . $this->sort->getOrder($this->order) : "";
    }

    public $sql_params = array();

    function sqlParams()
    {
        return $this->sql_params;
    }

    function addSqlParam()
    {
        $num = func_num_args();
        if ($num > 1) {
            $key = func_get_arg(0);
            $value = func_get_arg(1);
        } else {
            $key = '_PARAM_' . count($this->sql_params) . '_';
            $value = func_get_arg(0);
        }
        $this->sql_params[$key] = $value;
        return $key;
    }

}

class AdminManagerItem
{

    public $manager;
    protected $data;
    public $id;

    function __construct($data)
    {
        if (is_string($data) || is_numeric($data)) $data = array('id' => $data);
        if (!is_object($data)) $data = (object)$data;
        $this->data = $data;
        if (isset($data->id)) $this->id = $data->id;
    }

    function __get($name)
    {
        return isset($this->data->$name) ? $this->data->$name : null;
    }

}

class AdminManagerCol extends AdminManagerItem
{

    public $table = null;
    public $field;
    public $label;
    public $sortable = true;
    public $action = null;

    function __construct($data)
    {
        parent::__construct($data);
        $this->field = isset($data['field']) ? $data['field'] : $this->id;
        $this->label = isset($data['label']) ? $data['label'] : ucwords(str_replace("_", " ", $this->id));
        if (array_key_exists('action', $data)) {
            $this->action = $data['action'];
        } else {
            $this->action = "edit";
        }
        if (array_key_exists('sortable', $data)) $this->sortable = (bool)$data['sortable'];
    }

    function html($row)
    {
        $field = $this->field;
        return htmlspecialchars($row->$field, ENT_QUOTES, 'UTF-8');
    }

    function label()
    {
        return htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8');
    }

    function field()
    {
        return ($this->table ? $this->table . "." : "") . $this->field;
    }

    function action()
    {
        $action = $this->manager->getRowAction($this->action);
        $attr = $action ? $action->colAction() : null;
        return $attr ? " " . $attr : "";
    }

    function getOrder($order)
    {
        if ($order != 'desc') $order = 'asc';
        if ($order == 'asc' && !$this->sort_reverse || $order == 'desc' && $this->sort_reverse) {
            return isset($this->sort_asc) ? $this->sort_asc : $this->field() . " ASC";
        } else {
            return isset($this->sort_desc) ? $this->sort_desc : $this->field() . " DESC";
        }
    }

}

class Position_AdminManagerCol extends AdminManagerCol
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'position', 'width' => 1
        ), $data));
    }

    function label()
    {
        return '<span title="' . parent::label() . '"'
            . ($this->relative_filter ? ' data-positions-relations="' . $this->relative_filter->label . '"' : '')
            . '>#</span>';
    }

    function html($row)
    {
        $manager = $this->manager;
        $sortable = $manager->sort === $this && $manager->order == 'asc';
        if ($sortable) {
            foreach ($manager->filters as $filter) {
                if ($filter === $this->relative_filter) {
                    $filterValue = $filter->value();
                    if ($filterValue === null || (is_array($filterValue) && count($filterValue) != 1)) {
                        $sortable = false;
                    }
                } elseif ($filter->value() !== null) $sortable = false;
                if (!$sortable) break;
            }
        }
        $html = '<a title="drag &amp; drop for change position" data-action-move="';
        $html .= $sortable ? $row->{$this->field} : 'none';
        $html .= '" data-id="' . $row->id . '" class="list-action action-move">Move</a>';
        return $html;
    }

    protected $relative_filter = null;

    function setRelativeFilter($filter)
    {
        $this->relative_filter = $filter;
    }

}

class Id_AdminManagerCol extends AdminManagerCol
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'id', 'width' => 1, 'action' => 'edit'
        ), $data));
    }

}

class Title_AdminManagerCol extends AdminManagerCol
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'title', 'truncate' => true, 'action' => 'edit'
        ), $data));
    }

}

class Approved_AdminManagerCol extends AdminManagerCol
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'approved', 'sort_reverse' => true, 'width' => 1, 'action' => 'edit'
        ), $data));
    }

    function html($row)
    {
        return $row->{$this->field} ? '<span class="text-green">Yes</span>' : '<span class="text-red">No</span>';
    }

}

class DateTime_AdminManagerCol extends AdminManagerCol
{

    public $format = '%b %e, %Y at %I:%M %p';

    function __construct($data = array())
    {
        if (isset($data['format'])) $this->format = $data['format'];
        parent::__construct(array_merge(array(
            'id' => 'datetime', 'width' => 1
        ), $data));
    }

    function html($row)
    {
        $val = $row->{$this->field};
        return $val && strpos($val, '0000-00-00') !== 0 ? strftime($this->format, strtotime($val)) : '';
    }

}

class Date_AdminManagerCol extends DateTime_AdminManagerCol
{

    public $id = 'date';
    public $format = '%b %e, %Y';

}

class Time_AdminManagerCol extends DateTime_AdminManagerCol
{

    public $id = 'time';
    public $format = '%I:%M %p';

}

class Thumb_AdminManagerCol extends AdminManagerCol
{

    function __construct($id)
    {
        parent::__construct(array(
            'id' => $id, 'width' => 1, 'sortable' => false
        ));
    }

    function html($row)
    {
        $val = $row->{$this->field};
        static $i = 0;
        return $val
            ? '<a class="thumb" data-lightbox="image-orig-' . $i++ . '" target="_blank" href="/site_media/' . $val . '/">'
            . '<img src="/site_media/' . $val . '/_thumbs/">'
            . '</a>'
            : '';
    }

}

class AdminManagerRow extends AdminManagerItem
{

    final function html(AdminManagerCol $col)
    {
        return $col->html($this);
    }

}

class AdminManagerFilter extends AdminManagerItem
{

    public $field;
    public $multiple_field = false;
    public $label;
    public $type = 'text';
    public $multiple = false;
    public $options;

    function __construct($data)
    {
        parent::__construct($data);
        $this->field = isset($data['field']) ? $data['field'] : $this->id;
        $this->label = isset($data['label']) ? $data['label'] : ucwords(str_replace("_", " ", $this->id));

        if (isset($data['type']) && $data['type']) $this->type = $data['type'];
        if (isset($data['multiple'])) $this->multiple = $data['multiple'];
        if (isset($data['multiple_field'])) $this->multiple_field = $data['multiple_field'];

        if ($this->type == 'select') $this->multiple = true;

        if (in_array($this->type, array('select', 'radio', 'checkbox'))) {
            $this->options = isset($data['options']) ? $data['options'] : null;
            if (!$this->options) {
                $values = isset($data['values']) ? $data['values'] : null;
                if ($values) {
                    $output = isset($data['output']) ? $data['output'] : null;
                    if (!$output) $output = $values;
                    $this->options = array_combine($values, $output);
                }
            }
        } elseif ($this->type == 'date') {
            $this->multiple = true;
        } elseif ($this->type == 'range') {
            $this->multiple = true;
            $this->options = isset($data['options']) ? $data['options'] : null;
        }
    }

    function value()
    {
        if ($this->type == 'date') {
            $value = array();
            foreach (array('from', 'to') as $i) {
                $value[$i] = array();
                foreach (array('year', 'month', 'date') as $j) {
                    $k = $i . '_' . $j;
                    $value[$i][$j] = isset($_GET[$this->id][$k]) ? intval($_GET[$this->id][$k]) : 0;
                    if ($value[$i][$j] > 0 && $value[$i][$j] < 10) $value[$i][$j] = '0' . $value[$i][$j];
                }
                $value[$i] = in_array(0, $value[$i]) ? null : implode("-", $value[$i]);
            }
            if (!$value['from'] && !$value['to']) $value = null;
        } elseif ($this->type == 'range') {
            $value = array();
            $value['from'] = isset($_GET[$this->id]['from']) ? intval($_GET[$this->id]['from']) : 0;
            $value['to'] = isset($_GET[$this->id]['to']) ? intval($_GET[$this->id]['to']) : 0;
            if (!$value['from'] && !$value['to']) $value = null;
        } elseif ($this->multiple) {
            $value = isset($_GET[$this->id]) && is_array($_GET[$this->id]) ? array_map("trim", $_GET[$this->id]) : array();
            $value = array_intersect($value, array_keys($this->options));
            if (!$value) $value = null;
        } else {
            $value = isset($_GET[$this->id]) && is_string($_GET[$this->id]) ? trim($_GET[$this->id]) : null;
            if ($value == '') $value = null;
            elseif ($this->options && !in_array($value, array_keys($this->options))) $value = null;
        }
        return $value;
    }

    function sqlWhere()
    {
        $sql = "";
        $value = $this->value();
        if ($value !== null) {
            if ($this->type == 'date') {
                if ($value['from'] == null && $value['to'] != null) {
                    $sql .= "DATE(" . $this->field . ")<='" . $this->manager->addSqlParam($value['to']) . "'";
                } elseif ($value['from'] != null && $value['to'] == null) {
                    $sql .= "DATE(" . $this->field . ")>='" . $this->manager->addSqlParam($value['from']) . "'";
                } elseif ($value['from'] != null && $value['to'] != null) {
                    $sql .= "DATE(" . $this->field . ") BETWEEN '" . $this->manager->addSqlParam($value['from']) . "'";
                    $sql .= " AND '" . $this->manager->addSqlParam($value['to']) . "'";
                }
            } elseif ($this->type == 'range') {
                $sql .= $this->field . ">=" . $this->manager->addSqlParam($value['from']);
                $sql .= " AND " . $this->field . "<=" . $this->manager->addSqlParam($value['to']);
            } elseif (in_array($this->type, array('select', 'radio', 'checkbox'))) {
                if ($this->multiple) {
                    if ($this->multiple_field) {
                        $parts = array();
                        foreach ($value as $v) {
                            $parts[] = "FIND_IN_SET('" . $this->manager->addSqlParam($v) . "', " . $this->field . ")";
                        }
                        $sql .= "(" . implode(" OR ", $parts) . ")";
                    } else {
                        $sql .= "FIND_IN_SET(" . $this->field . ", '" . $this->manager->addSqlParam(implode(",", $value)) . "')";
                    }
                } else {
                    if ($this->multiple_field) {
                        $sql .= "FIND_IN_SET('" . $this->manager->addSqlParam($value) . "', " . $this->field . ")";
                    } else {
                        $sql .= $this->field . "='" . $this->manager->addSqlParam($value) . "'";
                    }
                }
            } else {
                $sql .= $this->field . " LIKE '%" . $this->manager->addSqlParam($value) . "%'";
            }
        }
        return $sql;
    }

    function html()
    {
        $html = '';
        $value = $this->value($this->id);
        $name = $this->id;
        if ($this->multiple) $name .= '[]';

        if ($this->type == 'date') {

            $name = $this->id;
            function select($name, $options, $value = null)
            {
                $html = '<select name="' . $name . '">';
                foreach ($options as $v => $t) {
                    $html .= '<option';
                    $html .= ' value="' . htmlspecialchars($v, ENT_QUOTES) . '"';
                    if (intval($value) == $v) $html .= ' selected="selected"';
                    $html .= '>';
                    $html .= htmlspecialchars($t, ENT_QUOTES);
                    $html .= '</option>';
                }
                $html .= '</select>';
                return $html;
            }

            $value['from'] = $value['from'] !== null ? explode("-", $value['from']) : array(0, 0, 0);
            $value['to'] = $value['to'] !== null ? explode("-", $value['to']) : array(0, 0, 0);

            $y = (int)date("Y");
            $ry = range($y - 100, $y + 2);
            $ry = array_reverse(array_combine($ry, $ry), true);
            $rm = range(1, 12);
            $rm = array_combine($rm, $rm);
            $rd = range(1, 31);
            $rd = array_combine($rd, $rd);

            $html = '<div class="date-filter">';
            $html .= '<div>';
            $html .= select($name . '[from_month]', array('' => 'MM') + $rm, $value['from'][1]);
            $html .= select($name . '[from_date]', array('' => 'DD') + $rd, $value['from'][2]);
            $html .= select($name . '[from_year]', array('' => 'YYYY') + $ry, $value['from'][0]);
            $html .= '</div>';
            $html .= '<div class="text">to</div>';
            $html .= '<div>';
            $html .= select($name . '[to_month]', array('' => 'MM') + $rm, $value['to'][1]);
            $html .= select($name . '[to_date]', array('' => 'DD') + $rd, $value['to'][2]);
            $html .= select($name . '[to_year]', array('' => 'YYYY') + $ry, $value['to'][0]);
            $html .= '</div>';
            $html .= '</div>';

        } elseif ($this->type == 'range') {
            $name = $this->id;
            $html = '<div class="range-filter">';
            $html .= '<div class="range-label">';
            $html .= isset($this->options["symbol"]) ? $this->options["symbol"] : "";
            $html .= '<input type="text" name="' . $name . '[from]" value="' . $value['from'] . '">';
            $html .= '<span>-</span>';
            $html .= isset($this->options["symbol"]) ? $this->options["symbol"] : "";
            $html .= '<input type="text" name="' . $name . '[to]" value="' . $value['to'] . '">';
            $html .= '</div>';
            $html .= '<div class="range-bar" data-min="' . (isset($this->options["min"]) ? $this->options["min"] : 0) . '" ';
            $html .= 'data-max="' . (isset($this->options["max"]) ? $this->options["max"] : 1000) . '"></div>';
            $html .= '</div>';
        } elseif ($this->type == 'select') {
            $html = '<select name="' . $name . '"';
            if ($this->multiple) $html .= ' multiple="multiple"';
            $html .= '>';
            if (!$this->multiple) $html .= '<option value="">none (default)</option>';
            foreach ($this->options as $v => $t) {
                $html .= '<option';
                $html .= ' value="' . htmlspecialchars($v, ENT_QUOTES) . '"';
                if ($value !== null && ($this->multiple && in_array($v, $value) || !$this->multiple && $v == $value)) $html .= ' selected="selected"';
                $html .= '>';
                $html .= '' . htmlspecialchars($t, ENT_QUOTES) . '';
                $html .= '</option>';
            }
            $html .= '</select>';
        } elseif (in_array($this->type, array('radio', 'checkbox'))) {
            foreach ($this->options as $v => $t) {
                $html .= '<label>';
                $html .= ' <input';
                $html .= ' type="' . $this->type . '"';
                $html .= ' name="' . $name . '"';
                $html .= ' value="' . htmlspecialchars($v, ENT_QUOTES) . '"';
                if ($value !== null && ($this->multiple && in_array($v, $value) || !$this->multiple && $v == $value)) $html .= ' checked="checked"';
                $html .= ' />';
                $html .= ' ' . htmlspecialchars($t, ENT_QUOTES);
                $html .= '</label>';
            }
        } else {
            $html = '<input type="text" name="' . $name . '"';
            if ($value !== null) $html .= ' value="' . htmlspecialchars($value, ENT_QUOTES) . '"';
            $html .= ' />';
        }

        return $html;
    }

}

class AdminManagerAction extends AdminManagerItem
{

    public $label;

    function __construct($data)
    {
        parent::__construct($data);
        $this->label = isset($data['label']) ? $data['label'] : ucwords(str_replace("_", " ", $data['id']));
    }

}

class Common_AdminManagerAction extends AdminManagerAction
{

    function html($label = null)
    {
        $label = $label ?: $this->label;
        return '<a href="' . $this->url . '" class="button1">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
    }

}

class Batch_AdminManagerAction extends AdminManagerAction
{

    function html()
    {
        $label = htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8');
        return '<a href="#" class="list-action'
            . ' action-' . $this->id . '"'
            . ' data-post-action="' . $this->id . '" data-id="batch"'
            . ' title="' . $label . '">' . $label . '</a>';
    }

}

class Row_AdminManagerAction extends AdminManagerAction
{

    function colAction()
    {
        return 'data-row-action=".action-' . $this->id . '"';
    }

    function html($row)
    {
        $label = htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8');
        return '<a href="javascript:;" class="list-action'
            . ' action-' . $this->id . '"'
            . ' data-post-action="' . $this->id . '" data-id="' . $row->id . '"'
            . ' title="' . $label . '">' . $label . '</a>';
    }

}

class Link_Row_AdminManagerAction extends Row_AdminManagerAction
{

    function __construct($data)
    {
        if (!isset($data['replace'])) $data['replace'] = 'id';
        if (!isset($data['target'])) $data['target'] = '';
        parent::__construct($data);
    }

    function colAction()
    {
        return 'data-row-action=".action-' . $this->id . ',href"';
    }

    function href($row)
    {
        return str_replace('%' . $this->replace . '%', $row->{$this->replace}, $this->url);
    }

    function html($row)
    {
        $label = htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8');
        return '<a href="' . $this->href($row) . '"'
            . ($this->target ? ' target="' . $this->target . '"' : '')
            . ' class="list-action action-' . $this->id . '"'
            . ' title="' . $label . '">' . $label . '</a>';
    }

}

class OnHome_Batch_AdminManagerAction extends Batch_AdminManagerAction
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array('id' => 'onhome', 'field' => 'on_home', 'label' => 'Display on Homepage'), $data));
    }

}

class OnHome_Row_AdminManagerAction extends Row_AdminManagerAction
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array('id' => 'onhome', 'field' => 'on_home'), $data));
    }

    function html($row)
    {
        $label = $row->{$this->field} ? 'Feature on homepage' : 'Feature on homepage';
        return '<a href="#" class="list-action'
            . ' action-onhome-' . ($row->{$this->field} ? 'off' : 'on') . '"'
            . ' data-post-action="' . $this->id . '" data-id="' . $row->id . '"'
            . ' title="' . $label . '">' . $label . '</a>';
    }

}

class Toggle_Row_AdminManagerAction extends Row_AdminManagerAction
{

    function __construct($data = array())
    {
        $field = isset($data['field']) ? $data['field'] : 'status';
        parent::__construct(array_merge(array('id' => 'toggle', 'field' => $field), $data));
    }

    function html($row)
    {
        $label = $row->{$this->field} ? 'Disable' : 'Enable';
        return '<a href="#" class="list-action'
            . ' action-status-' . ($row->{$this->field} ? 'off' : 'on') . '"'
            . ' data-post-action="' . $this->id . '" data-id="' . $row->id . '"'
            . ' title="' . $label . '">' . $label . '</a>';
    }

}

class Delete_Row_AdminManagerAction extends Row_AdminManagerAction
{

    function __construct($data = array())
    {
        parent::__construct(array_merge(array('id' => 'delete'), $data));
    }

    function html($row)
    {
        return $row->readonly == 1 ? '' : parent::html($row);
    }

}

?>

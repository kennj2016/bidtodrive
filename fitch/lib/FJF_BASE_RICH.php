<?php

class FJF_BASE_RICH
{

    /**
     * Gets single record from DB table
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @return mixed
     */
    public static function getRecord($table = "", $where = "", $whereParams = null)
    {
        $record = null;
        try {
            if (!$table) {
                throw new DatabaseException("Table is not specified");
            }
            FJF_BASE::db_open();
            $record = FJF_BASE::db_get_one($table, FJF_BASE::replace_params($where, $whereParams));
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $record;
    }


    /**
     * Gets single record from DB table using specified primary key
     * @param string $table
     * @param integer $recordID
     * @param string $primaryKey
     * @return mixed
     */
    public static function getRecordBy($table = "", $recordID = 0, $primaryKey = "id")
    {
        return FJF_BASE_RICH::getRecord($table, "PRIMARY_KEY='RECORD_ID'", array("PRIMARY_KEY" => $primaryKey, "RECORD_ID" => $recordID));
    }


    /**
     * Gets multiple records from DB table
     * @param string $sql
     * @param array $whereParams
     * @param boolean $returnOne
     * @return mixed
     */
    public static function selectRecords($sql, $whereParams = null, $returnOne = false)
    {
        $result = null;
        try {
            if (!$sql) {
                throw new DatabaseException("SQL query is empty");
            }
            FJF_BASE::db_open();
            $result = FJF_BASE::db_get_many(FJF_BASE::replace_params($sql, $whereParams));
            if ($result && $returnOne) {
                $result = $result[0];
            }
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $result;
    }


    /**
     * Gets multiple records from DB table
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @param boolean $returnOne
     * @param string $select
     * @return mixed
     */
    public static function getRecords($table = "", $where = "", $whereParams = null, $returnOne = false, $select = "*")
    {
        $sql = "SELECT " . $select . " FROM " . $table . ($where ? " WHERE " . $where : "");
        return FJF_BASE_RICH::selectRecords($sql, $whereParams, $returnOne);
    }


    /**
     * Gets multiple records from DB table and converts them to associative array
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @param string $key
     * @param string $value
     * @return array
     */
    public static function getList($table = "", $where = "", $whereParams = null, $key = "id", $value = "title")
    {
        if (!$where) {
            $where = "TRUE ORDER BY " . $value;
        }
        return FJF_BASE_RICH::toList(
            FJF_BASE_RICH::getRecords($table, $where, $whereParams, false, $key . ", " . $value),
            $key,
            $value
        );
    }


    /**
     * Converts array of objects to one-dimensional associative array
     * @param array $records
     * @param string $key
     * @param string $value
     * @return array
     */
    public static function toList($records, $key = "id", $value = "title")
    {
        $result = array();
        if ($records) {
            foreach ($records as $i => $v) $result[$v->{$key}] = $v->{$value};
        }
        return $result;
    }

    /**
     * Counts records
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @param string $field
     * @return integer
     */
    public static function countFrom($table = "", $where = "", $whereParams = null, $field = null)
    {
        if (!$field) {
            $field = 'id';
        }
        $sql = "SELECT COUNT(" . $field . ") cid FROM " . $table . ($where ? " WHERE " . $where : "");
        $result = FJF_BASE_RICH::selectRecords($sql, $whereParams, true);
        return $result ? (int)$result->cid : 0;
    }


    /**
     * Updates record
     * @param string $table
     * @param array $data
     * @param string $key
     * @param string $key2
     * @return boolean
     */
    public static function updateRecord($table = "", $data, $key = "id", $key2 = null)
    {
        $result = false;
        try {
            FJF_BASE::db_open();
            $result = FJF_BASE::db_update(
                $table,
                $data,
                $key . "='" . FJF_BASE::db_escape($data[$key]) . "'" . ($key2 ? " AND " . $key2 . "='" . FJF_BASE::db_escape($data[$key2]) . "'" : ""
                ));
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $result;
    }

    /**
     * Inserts record
     * @param string $table
     * @param array $data
     * @param string $key
     * @return integer
     */
    public static function insertRecord($table, $data, $key = "id")
    {
        $result = null;
        try {
            FJF_BASE::db_open();
            $result = FJF_BASE::db_insert($table, $data, $key);
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $result;
    }


    /**
     * Replaces record
     * @param string $table
     * @param array $data
     * @return boolean
     */
    public static function replaceRecord($table = "", $data)
    {
        $result = null;
        try {
            FJF_BASE::db_open();
            $result = FJF_BASE::db_replace($table, $data);
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $result;
    }

    /**
     * Saves record to DB table
     * @param string $table
     * @param array $data
     * @param string $key
     * @param string $key2
     * @return mixed
     */
    public static function saveRecord($table = "", $data, $key = "id", $key2 = null)
    {
        if (isset($data[$key])) {
            return FJF_BASE_RICH::updateRecord($table, $data, $key, $key2);
        } else {
            return FJF_BASE_RICH::insertRecord($table, $data, $key);
        }
    }


    /**
     * Executes SQL query
     * @param string $sql
     * @param array $params
     * @return boolean
     */
    public static function executeQuery($sql, $params = null)
    {
        $result = null;
        try {
            FJF_BASE::db_open();
            $result = FJF_BASE::db_execute(FJF_BASE::replace_params($sql, $params));
        } catch (DatabaseException $e) {
            FJF_BASE::log($e, __METHOD__);
        }
        return $result;
    }


    /**
     * Updates DB table records
     * @param string $table
     * @param string $set
     * @param string $where
     * @param array $whereParams
     * @return boolean
     */
    public static function updateRecords($table = "", $set, $where = "1", $whereParams = null)
    {
        return FJF_BASE_RICH::executeQuery("UPDATE " . $table . " SET " . $set . " WHERE " . $where, $whereParams);
    }


    /**
     * Deletes records from DB table
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @return boolean
     */
    public static function deleteRecords($table = "", $where, $whereParams = null)
    {
        return FJF_BASE_RICH::executeQuery("DELETE FROM " . $table . " WHERE " . $where, $whereParams);
    }


    /**
     * Deletes single record from DB table using specified key
     * @param string $table
     * @param integer $recordID
     * @param string $primaryKey
     * @return boolean
     */
    public static function deleteRecord($table = "", $recordID = 0, $primaryKey = "id")
    {
        return FJF_BASE_RICH::deleteRecords($table, "PRIMARY_KEY='RECORD_ID'", array("PRIMARY_KEY" => $primaryKey, "RECORD_ID" => $recordID));
    }


    /**
     * Generates URL title
     * @param string $text
     * @param integer $id
     * @param string $table
     * @param string $field
     * @param string $delim
     * @return string
     */
    public static function generateURL($text, $id, $table, $field = "url_title", $delim = "-")
    {
        $text = trim(preg_replace("/[^" . $delim . "A-Za-z0-9]+/", $delim, strtolower($text)), $delim);
        if ($similarURLs = FJF_BASE_RICH::getRecords(
            $table, $field . " REGEXP '^(" . $text . "|" . $text . $delim . "[[:digit:]]+)$'", null, null, "id, " . $field
        )) {
            foreach ($similarURLs as $k => $v) {
                $n = str_replace(array($text, $delim), "", $v->$field);
                if ($id > 0 && $v->id == $id) {
                    return $v->$field;
                }
                $similarURLs[$k] = $n;
            }
            $similarURLs = array_map("intval", $similarURLs);
            sort($similarURLs, SORT_NUMERIC);
            $text .= $delim . (array_pop($similarURLs) + 1);
        }
        return $text;
    }


    /**
     * Adds query parameters to URL
     * @param string $href
     * @param mixed $query
     * @return string
     */
    public static function URLJoinQuery($href, $query)
    {
        $href = parse_url($href);

        if (isset($href["query"])) {
            parse_str($href["query"], $hrefQuery);
        } else {
            $hrefQuery = array();
        }

        if (is_string($query)) {
            parse_str($query, $query);
        }

        $href["query"] = http_build_query(array_merge($hrefQuery, $query));

        $href = (isset($href["path"]) ? $href["path"] : "") . "?" . $href["query"] . (isset($href["fragment"]) ? "#" . $href["fragment"] : "");
        return $href;
    }


    /**
     * Redirects to a new location with a custom parameter added
     * @param string $location
     * @param string $return
     */
    public static function redirectWithReturn($location, $return = "return")
    {
        if (isset($_GET[$return])) {
            $location = FJF_BASE_RICH::URLJoinQuery($redirect, array($return => $_GET[$return]));
        }
        FJF_BASE::redirect($location);
    }

}

?>
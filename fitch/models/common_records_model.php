<?php

class CommonRecordsModel
{

    static function getRecords($args, $fields, $table, $where, $orders)
    {
        $args = CommonRecordsModel::getRecordsArguments($args);
        $sqlWhere = CommonRecordsModel::getRecordsWhere($args, $where);
        $sqlWhere .= CommonRecordsModel::getRecordsOrder($args, $orders);
        $sqlWhere .= CommonRecordsModel::getRecordsLimit($args);
        if (isset($args['key'])) $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = $args['key'];
        return FJF_BASE_RICH::getRecords(
            $table, $sqlWhere, $args['params'], null, isset($args["fields"]) ? $args["fields"] : $fields
        );
    }

    static function getRecordsTotal($args, $table, $where, $field = null)
    {
        $args = CommonRecordsModel::getRecordsArguments($args);
        $sqlWhere = CommonRecordsModel::getRecordsWhere($args, $where);
        return FJF_BASE_RICH::countFrom(
            $table, $sqlWhere, $args['params'], $field
        );
    }

    static function getRecordsArguments($arguments)
    {
        $names = array('where', 'params', 'order', 'limit');
        $result = array_combine($names, array(null, null, null, 5));
        $num = count($arguments);
        if ($num == 1) {
            if (!is_array($arguments[0])) $result['where'] = $arguments[0];
            else $result = array_merge($result, $arguments[0]);
        } elseif ($num > 1) {
            for ($i = 0; $i < 4; $i++) if (isset($arguments[$i])) $result[$names[$i]] = $arguments[$i];
        }
        return $result;
    }

    static function getRecordsWhere($args, $where)
    {
        $parts = array();
        if ($where) $parts[] = $where;
        if ($args['where']) $parts[] = $args['where'];
        if ($parts) {
            if (count($parts) > 1) return "(" . implode(") AND (", $parts) . ")";
            return $parts[0];
        }
        return 'TRUE';
    }

    static function getRecordsOrder($args, $orders)
    {
        if (!in_array($args['order'], $orders) && !isset($args['custom_order'])) $args['order'] = $orders[0];
        return " ORDER BY " . $args['order'];
    }

    static function getRecordsLimit($args)
    {
        return $args['limit'] ? " LIMIT " . preg_replace("/[^\d,]+/", "", $args['limit']) : "";
    }

    static function getIds($records, $field, $str = false)
    {
        $ids = array();
        foreach ($records as $record) if ($record->$field) $ids[] = $record->$field;
        if ($ids) $ids = array_unique(explode(",", implode(",", $ids)));
        return $str ? implode(",", $ids) : $ids;
    }

    static function fillItems($records, $itemId, $items, $itemValue, $multiple = false)
    {
        if ($records && $items) foreach ($records as $record) {
            if (!isset($record->$itemValue)) $record->$itemValue = $multiple ? array() : null;
            if ($multiple) {
                foreach (explode(",", $record->$itemId) as $id) {
                    if (array_key_exists($id, $items)) $record->{$itemValue}[] = $items[$id];
                }
            } else {
                if (array_key_exists($record->$itemId, $items)) $record->$itemValue = $items[$record->$itemId];
            }
        }
    }

    static function findInArr($records, $key, $value)
    {
        if ($records && $value) foreach ($records as $record) {
            if ($record->$key == $value) return $record;
        }
        return null;
    }

    static function getSiteVars()
    {
        static $vars = null;
        if ($vars === null) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = 'name';
            if ($vars = FJF_BASE_RICH::getRecords(
                "site_vars",
                null,
                null,
                null,
                "name, value"
            )) {
                foreach ($vars as $i => $o) $vars[$i] = $o->value;
            } else $vars = array();
        }
        return $vars;
    }

    static function getSiteVar($name)
    {
        $vars = CommonRecordsModel::getSiteVars();
        return array_key_exists($name, $vars) ? $vars[$name] : null;
    }

    static function getSiteData($type, $name)
    {
        $record = FJF_BASE_RICH::getRecords(
            "site_data",
            "type='TYPE_VAL' AND name='NAME_VAL' LIMIT 1",
            array('TYPE_VAL' => $type, 'NAME_VAL' => $name),
            true,
            'data'
        );
        return $record && $record->data ? json_decode($record->data) : null;
    }

    const TEMPLATE_PAGES_FROM = "pages";
    const TEMPLATE_PAGES_WHERE = "status=1 AND approved=1";

    static function getTemplatePage($urlTitle)
    {
        return $urlTitle ? FJF_BASE_RICH::getRecords(
            self::TEMPLATE_PAGES_FROM,
            self::TEMPLATE_PAGES_WHERE . " AND url_title='URL_TITLE' LIMIT 1",
            array('URL_TITLE' => $urlTitle),
            true
        ) : null;
    }

    static function getGlobalSeoController()
    {
        static $vars = null;
        if ($vars === null) {
            if ($records = FJF_BASE_RICH::getRecords(
                "global_seo_controller",
                "status = 1 ORDER BY position",
                null,
                null,
                "url, meta_title, meta_keywords, meta_description"
            )) {
                $replacement = "%%ALL%%";
                $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
                foreach ($records as $item) {
                    $item->is_main = $item->url != "*";
                    if (preg_match("/^" . str_replace($replacement, ".*", preg_quote(str_replace("*", $replacement, $item->url), "/")) . "$/", $url)) {
                        $vars = $item;
                        break;
                    }
                }
            }
        }
        return $vars;
    }

}

?>
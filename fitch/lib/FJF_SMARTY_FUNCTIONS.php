<?php

/**
 * @param $params
 * @param $content
 * @param $smarty
 * @param $repeat
 * @return string
 */
function smarty_is_admin($params, $content, &$smarty, &$repeat)
{
    return SessionModel::hasAdminPermissions(
        isset($params["tool"])
            ? $params["tool"]
            : $smarty->_tpl_vars["web_config"][$smarty->_tpl_vars["parameters"]["cmd"]]["tool_id"]
    ) ? $content : "";
}

$smartyEngine->register_block("is_admin", "smarty_is_admin");


/**
 * @param $params
 * @param $content
 * @param $smarty
 * @param $repeat
 * @return string
 */
function smarty_not_admin($params, $content, &$smarty, &$repeat)
{
    return SessionModel::hasAdminPermissions(
        isset($params["tool"])
            ? $params["tool"]
            : $smarty->_tpl_vars["web_config"][$smarty->_tpl_vars["parameters"]["cmd"]]["tool_id"]
    ) ? "" : $content;
}

$smartyEngine->register_block("not_admin", "smarty_not_admin");


/**
 * @param $params
 * @return int
 */
function smarty_random($params)
{
    $min = (array_key_exists("min", $params) && intval($params["min"]) >= 0) ? intval($params["min"]) : 0;
    $max = (array_key_exists("max", $params) && intval($params["max"]) > 0) ? intval($params["max"]) : 10000;
    $randomNumber = rand($min, $max);
    return $randomNumber;
}

$smartyEngine->register_function("random", "smarty_random");

/**
 * @param $params
 * @param $smarty
 * @return string
 */
function smarty_embed_video($params, &$smarty)
{
    $url = isset($params['url']) ? $params['url'] : null;
    $autoplay = isset($params['autoplay']) && $params['autoplay'];
    if ($url) {
        if (preg_match("/youtube\.com\/(watch\?v\=|video\/|embed\/)([^\&\?\#]+)/i", $url, $matches)) {
            $url = "//www.youtube.com/embed/" . $matches[2] . "?wmode=transparent&controls=0&showinfo=0";
            if ($autoplay) $url .= "&autoplay=1";
        } elseif (preg_match("/vimeo\.com\/(\d+)/i", $url, $matches)) {
            $url = "//player.vimeo.com/video/" . $matches[1];
            if ($autoplay) $url .= "?autoplay=1";
        }
        $html = '<iframe src="' . $url . '"';
        if (isset($params['width'])) $html .= ' width="' . $params['width'] . '"';
        if (isset($params['height'])) $html .= ' height="' . $params['height'] . '"';
        $html .= ' frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

        if (isset($params['var'])) $smarty->assign($params['var'], $html);
        else return $html;
    }
}

$smartyEngine->register_function("embed_video", "smarty_embed_video");

/**
 * @param $str
 * @return string
 */
function smarty_url_title($str)
{
    return strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $str), "-"));
}

$smartyEngine->register_modifier("url_title", "smarty_url_title");

/**
 * @param $id
 * @return bool|string
 */
function smarty_site_media_svg($id)
{
    include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
    return SiteMediaModel::getSvg($id);
}

$smartyEngine->register_modifier("site_media_svg", "smarty_site_media_svg");

/**
 * @param $params
 * @param $smarty
 */
function smarty_user_type($params, &$smarty)
{
    $smarty->assign($params['assign'], SessionModel::getUserType());
}

$smartyEngine->register_function("user_type", "smarty_user_type");

/**
 * @param $params
 * @param $smarty
 */
function smarty_user_uid($params, &$smarty)
{
    $smarty->assign($params['assign'], SessionModel::getUserUID());
}

$smartyEngine->register_function("user_uid", "smarty_user_uid");

/**
 * @param $params
 * @param $smarty
 */
function smarty_user_name($params, &$smarty)
{
    $smarty->assign($params['assign'], SessionModel::getUserName());
}

$smartyEngine->register_function("user_name", "smarty_user_name");

/**
 * for price, add commas every 3 digits (i.e. $100,000)
 * there can only be 2 decimal places after a price
 * if price ends in a .00 do not show the decimals
 * @param $value
 * @return mixed
 */
function smarty_money_format($value)
{
    return str_replace('.00', '', number_format($value, 2, '.', ','));
}

$smartyEngine->register_modifier("money_format", "smarty_money_format");
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class AjaxNotificationManual extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        header('Content-type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(SessionModel::sessionUser() == true) {
                http_response_code(200);
                $uid = SessionModel::sessionUser()->uid;
                FJF_BASE_RICH::updateRecords("notifications","is_read=1","uid='USER_UID'",array('USER_UID' => $uid));
            } else {
                http_response_code(403);
            }
            echo json_encode([]);exit();
        } else {
            $res = array(
                //'data' => [],
                'count' => 0
            );
            if(SessionModel::sessionUser() == true) {
                http_response_code(200);
                $uid = SessionModel::sessionUser()->uid;
                $data = FJF_BASE_RICH::selectRecords('SELECT * FROM notifications where is_read=0 and uid="' . $uid . '" ORDER BY id DESC LIMIT 50',null);
                $res['count'] = !empty($data[0]) ? count($data) : 0;
                $res['user_type'] = SessionModel::sessionUser()->user_type;
                date_default_timezone_set('EST');
                $format = "%b %d, %Y %I:%M:%S %Z";
                if (substr(PHP_OS,0,3) == 'WIN') {
                       $_win_from = array ('%e',  '%T',       '%D');
                       $_win_to   = array ('%#d', '%H:%M:%S', '%m/%d/%y');
                       $format = str_replace($_win_from, $_win_to, $format);
                }



                foreach ($data as $key => $value) {
                  $value->datetime = strftime($format, $this->smarty_make_timestamp($value->datetime));
                }
                $res['data'] = $data;
            } else {
                http_response_code(403);
            }
            echo json_encode($res);
        }
    }
    public function smarty_make_timestamp($string)
    {
        if(empty($string)) {
            // use "now":
            $time = time();

        } elseif (preg_match('/^\d{14}$/', $string)) {
            // it is mysql timestamp format of YYYYMMDDHHMMSS?
            $time = mktime(substr($string, 8, 2),substr($string, 10, 2),substr($string, 12, 2),
                           substr($string, 4, 2),substr($string, 6, 2),substr($string, 0, 4));

        } elseif (is_numeric($string)) {
            // it is a numeric string, we handle it as timestamp
            $time = (int)$string;

        } else {
            // strtotime should handle it
            $time = strtotime($string);
            if ($time == -1 || $time === false) {
                // strtotime() was not able to parse $string, use "now":
                $time = time();
            }
        }
        return $time;

    }
}



?>

<?php

class SessionModel
{
    public $user = null;

    /**
     * SessionModel constructor.
     */
    function __construct()
    {
        session_start();

        $this->user = $this->user();

        $id = isset($_COOKIE["userid"]) && $_COOKIE["userid"] ? FJF_BASE::decrypt($_COOKIE["userid"], "userid") : null;
        if (!$this->user && $id) {
            if ($user = FJF_BASE_RICH::getRecordBy("users", $id)) $this->login($user, true);
        }

        return true;
    }

    static function user()
    {
        $ccUserID = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;
        if (SessionModel::isAdmin() && $ccUserID && strpos($_SERVER["REQUEST_URI"], "/admin/") === false) {
            $ccUser = FJF_BASE_RICH::getRecordBy("users", $ccUserID);
            return $ccUser;
        } else {
            return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
        }
    }

    static function sessionUser()
    {
        return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
    }

    static function isAdmin()
    {
        $user = SessionModel::sessionUser();
        return $user && $user->is_admin;
    }

    static function isSuperAdmin()
    {
        $user = SessionModel::sessionUser();
        return $user && $user->is_admin == 2;
    }

    static function getUserUID()
    {
        $ccUserID = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;
        if (SessionModel::isAdmin() && $ccUserID) {
            $ccUser = FJF_BASE_RICH::getRecordBy("users", $ccUserID);
            return (is_object($ccUser)) ? $ccUser->uid : "";
        } else {
            $user = SessionModel::sessionUser();
            return (is_object($user)) ? $user->uid : "";
        }
    }

    static function hasAdminPermissions($toolId = null)
    {
        if (!SessionModel::isAdmin()) return false;
        if (SessionModel::isSuperAdmin()) return true;
        if ($toolId === null) {
            $toolId = isset($GLOBALS["WEB_APPLICATION_CONFIG"][$GLOBALS['REQUEST_CMD']]["tool_id"])
                ? $GLOBALS["WEB_APPLICATION_CONFIG"][$GLOBALS['REQUEST_CMD']]["tool_id"]
                : null;
        }
        if ($toolId && !is_array($toolId)) $toolId = array_map("trim", explode(",", $toolId));
        return !$toolId || array_intersect($toolId, SessionModel::sessionUser()->permissions);
    }

    static function requireAdmin($redirect = null)
    {
        if (!SessionModel::isAdmin()) {
            if (!$redirect) $redirect = "/admin/login/?redirect=" . urlencode($_SERVER["REQUEST_URI"]);
            FJF_BASE::redirect($redirect);
        }
    }

    static function requireAdminPermissions($toolId = null, $redirect = null)
    {
        SessionModel::requireAdmin($redirect);
        if (!SessionModel::hasAdminPermissions($toolId)) {
            if (!$redirect) $redirect = isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : "/admin/";
            FJF_BASE::redirect($redirect);
        }
    }

    static function redirectAdmin($redirect = null)
    {
        if (SessionModel::isAdmin()) {
            if (!$redirect) $redirect = "/admin/";
            FJF_BASE::redirect($redirect);
        }
    }

    static function isUser()
    {
        return !!SessionModel::sessionUser();
    }

    static function getUserType()
    {
        $ccUserID = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;
        if (SessionModel::isAdmin() && $ccUserID) {
            $ccUser = FJF_BASE_RICH::getRecordBy("users", $ccUserID);
            return (is_object($ccUser) && ($ccUser->user_type == "Seller" || $ccUser->user_type == "Buyer")) ? $ccUser->user_type : "";
        } else {
            $user = SessionModel::sessionUser();
            return ($user && ($user->user_type == "Seller" || $user->user_type == "Buyer")) ? $user->user_type : "";
        }
    }

    static function getUserName()
    {
        $ccUserID = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;
        if (SessionModel::isAdmin() && $ccUserID) {
            $ccUser = FJF_BASE_RICH::getRecordBy("users", $ccUserID);
            return (is_object($ccUser)) ? $ccUser->name : "";
        } else {
            $user = SessionModel::sessionUser();
            return ($user) ? $user->name : "";
        }
    }

    static function requireUser($redirect = null)
    {
        if (!SessionModel::isUser()) {
            if (!$redirect) $redirect = "/login/?redirect=" . urlencode($_SERVER["REQUEST_URI"]);
            FJF_BASE::redirect($redirect);
        }
    }

    static function redirectUser($redirect = null)
    {
        if (SessionModel::isUser()) {
            if (!$redirect) $redirect = "/";
            FJF_BASE::redirect($redirect);
        }
    }

    static function loggedUserID()
    {
        $ccUserID = (isset($_COOKIE["cc_user_id"])) ? $_COOKIE["cc_user_id"] : 0;
        if (SessionModel::isAdmin() && $ccUserID) {
            return $ccUserID;
        } else {
            return SessionModel::sessionUser()->id;
        }
    }

    function login($user, $remember = false)
    {
        if (!$user) return false;

        $time = time();
        unset($user->password);

        if ($user->is_admin == 1) {
            $record = FJF_BASE_RICH::getRecordBy("admin_permissions", $user->id, "user_id");
            $user->permissions = $record && $record->permissions ? explode(",", $record->permissions) : array();
        }

        FJF_BASE_RICH::saveRecord("users", array("id" => $user->id, "datetime_login" => date("Y-m-d H:i:s", $time)));

        $this->user = $user;
        $_SESSION["user"] = $user;
        if ($remember) setcookie(
            "userid",
            FJF_BASE::encrypt($user->id, "userid"),
            $time + 1209600,// 2 weeks
            "/"
        );
    }

    function logout()
    {
        if (isset($_COOKIE["userid"])) setcookie("userid", "", time() - 3600, "/");
        $_SESSION["user"] = null;
        $this->user = null;
    }

    static function getRandString($stringLength, $includeNumbers = true)
    {
        $allowedChars = array();
        // 65-90 : A-Z, 97-122 : a-z
        $i = 64;
        while ($i++ < 122) if (!($i > 90 && $i < 97)) $allowedChars[] = chr($i);
        if ($includeNumbers) for ($i = 0; $i <= 9; $i++) $allowedChars[] = $i;
        $num = count($allowedChars);
        $string = '';
        while ($stringLength-- > 0) $string .= $allowedChars[mt_rand(0, $num - 1)];
        return $string;
    }

    static function updatePassword($id, $password)
    {
        return ($id && $password) ? FJF_BASE_RICH::saveRecord(
            "users", array("id" => $id, "password_refresh" => null, "password" => md5($password))
        ) : null;
    }

    static function setTimezone($timezone = '')
    {
        date_default_timezone_set($timezone);
    }

    static function setDefaultTimezone()
    {
        date_default_timezone_set(ini_get('date.timezone'));
    }


}

?>

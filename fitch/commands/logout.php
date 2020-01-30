<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");

class Logout extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        $this->sessionModel->logout();
        if (!$this->isAjax()) {
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
            FJF_BASE::redirect($redirect ? $redirect : '/');
        }
    }
}

?>
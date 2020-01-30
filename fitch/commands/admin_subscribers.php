<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminSubscribers extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Subscribers');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("form_contact");
            $manager->registerPostAction("delete");
            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }
        }

        $manager = new AdminManager();
        $manager->setOption(array(
            'table' => 'form_contact'
        ));

        $manager->addFilters(array(
            'name',
            'email'
        ));

        if (isset($_GET["action"]) && $_GET["action"] == "export") $manager->export(
            array("datetime" => "Date", "name" => "Name", "email" => "Email", "subject" => "Subject", "body" => "Body"),
            array('filename' => 'subscribers-export-' . time())
        );

        $manager->addCols(array(
            new Id_AdminManagerCol,
            array(
                'id' => 'name',
                'action' => 'view',
                'sort' => 'DESC'
            ),
            array(
                'id' => 'email',
                'action' => 'view'
            ),
            new DateTime_AdminManagerCol(array(
                    'id' => 'datetime',
                    'label' => 'date',
                    'action' => 'view',
                    'width' => 1
                )
            )
        ));

        $manager->addCommonActions(array(
            array(
                'id' => 'export',
                'url' => '/admin/subscribers/?' . parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY) . '&action=export'
            )
        ));

        $manager->addBatchActions(array(
            'delete'
        ));

        $manager->addRowActions(array(
            new ViewAction,
            'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_subscribers.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        $header['include'] = '<script type="text/javascript" src="/js/admin/cmd/admin_subscribers.js"></script>';

        return $this->displayTemplate("admin_subscribers.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

class ViewAction extends Row_AdminManagerAction
{
    function __construct()
    {
        parent::__construct(array('id' => 'view'));
    }

    function html($row)
    {
        $html = '<p>';
        $html .= '<strong>Name</strong>: ' . htmlentities($row->name, ENT_QUOTES) . '<br />';
        $html .= '<strong>Email</strong>: ' . htmlentities($row->email, ENT_QUOTES) . '<br />';
        $html .= '<strong>Message</strong>: ' . htmlentities($row->message, ENT_QUOTES) . '<br />';
        $html .= '<strong>Form</strong>: ' . htmlentities($row->form, ENT_QUOTES) . '<br />';
        $html .= '<strong>Contact Reason</strong>: ' . htmlentities($row->contact_reason, ENT_QUOTES);
        $html .= '</p>';

        return '<a href="#" class="list-action action-view"'
            . ' data-action-view="' . htmlentities($html, ENT_QUOTES) . '"'
            . ' title="View">View</a>';
    }
}

?>
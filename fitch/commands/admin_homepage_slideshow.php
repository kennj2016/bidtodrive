<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminHomepageSlideshow extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Homepage: Slideshow');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("homepage_slideshow");
            $manager->hasPositions();

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $manager = new AdminManager();
        $manager->hasPositions();
        $manager->setOption(array(
            'table' => 'homepage_slideshow'
        ));

        $manager->addFilters(array(
            'title',
            array(
                'id' => 'status',
                'type' => 'select',
                'options' => array(
                    1 => 'Active',
                    0 => 'Inactive'
                )
            )
        ));

        $manager->addCols(array(
            new Id_AdminManagerCol,
            new Title_AdminManagerCol,
            new Thumb_AdminManagerCol('image')
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/homepage/slideshow/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            array('id' => 'delete', 'label' => 'Remove')
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/homepage/slideshow/%id%/'
            )),
            new Toggle_Row_AdminManagerAction(),
            'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_homepage_slideshow.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_homepage_slideshow.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

?>
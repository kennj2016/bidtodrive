<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminBlogPosts extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Blog Posts');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("blog_posts");
            $manager->hasRevisions();

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction(
                "duplicate",
                null,
                null,
                null,
                'title',
                'url_title'
            );

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $manager = new AdminManager();
        $manager->setOption(array(
            'table' => 'blog_posts',
            'default_sort' => 'id'
        ));

        $manager->addFilters(array(
            array(
                'id' => 'title',
                'field' => 'title',
                'label' => 'title'
            ),
            array(
                'id' => 'status',
                'field' => 'status',
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
            new DateTime_AdminManagerCol(array(
                'id' => 'blog_posts_date',
                'field' => 'datetime_publish',
                'label' => 'date',
                'action' => 'edit',
                'width' => 1
            )),
            new Approved_AdminManagerCol
        ));

        $manager->addCommonAction(array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/blog/posts/add/'));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove')
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/blog/posts/%id%/'
            )),
            new Toggle_Row_AdminManagerAction(),
            'duplicate', 'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_blog_posts.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_blog_posts.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

?>
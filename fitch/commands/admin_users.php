<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

class AdminUsers extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {

        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        try{
            FJF_BASE::capsuleOpen();
        }
        catch (Exception $e){
            return $e->getMessage();
        }
        catch (Throwable $e){
            return $e->getMessage();
        }


        $mode = isset($_GET['mode']) && in_array($_GET['mode'], array('users', 'administrators')) ? $_GET['mode'] : null;
        // $mode = "users";
        // print_r($mode);die;
        if (!$mode) FJF_BASE::redirect("/admin/");
        $this->setToolTitle(ucfirst($mode));

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("users");

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction(
                "duplicate", null,
                array('datetime_register' => null, 'datetime_login' => null),
                array('email', 'password', 'password_refresh', 'created_by'),
                'name'
            );
            if(@$_POST['command'] == 1){
                $user = Illuminate\Database\Capsule\Manager::table('users')
                    ->whereIn('id', $_POST['ids'])
                    ->first();
                MailModel::sendRejectSellerRequest($user, $_POST['reason']);
            }

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $manager = new Manager();
        $manager->setOption(array(
            'table' => 'users',
            'default_sort' => 'id'
        ));
        $manager->setData('mode', $mode);

        $manager->addFilters(array(
            'name',
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
            new Title_AdminManagerCol(array(
                'id' => 'name'
            )),
            array(
                'id' => 'email',
                'action' => 'edit'
            ),
            array(
                'id' => 'user_type',
            )
            // array(
            //     'id' => 'upgrade_seller_note',
            // )
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New User', 'url' => '/admin/' . $mode . '/add/'),
            array('id' => 'button', 'label' => 'Manager Request Seller ', 'url' => '/admin/users-request-seller/'),
        ));

        $manager->addBatchActions(array(
            'toggle',
            // 'duplicate',
            array('id' => 'delete', 'label' => 'Remove')
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/' . $mode . '/%id%/'
            ))
        ));

        if ($mode == 'administrators') {
            $manager->addCol(new SuperAdminCol(array(
                'id' => 'super',
                'label' => 'Super Admin',
                'field' => 'is_admin',
                'sort_reverse' => true,
                'action' => 'edit'
            )));
            $manager->addRowAction(new PermissionsAction(array(
                'id' => 'access',
                'url' => '/admin/' . $mode . '/%id%/permissions/'
            )));
            $manager->addFilter(array(
                'id' => 'type',
                'type' => 'select',
                'field' => 'is_admin',
                'label' => 'Admin Type',
                'options' => array(
                    1 => 'Common Admin',
                    2 => 'Super Admin'
                )
            ));
        }

        $manager->addRowActions(array(
            new Toggle_Row_AdminManagerAction(),
            // 'duplicate',
            'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_users.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }
        $manager->rows = array_reverse($manager->rows);
        return $this->displayTemplate("admin_users.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }

}

class Manager extends AdminManager
{

    function sqlWhere()
    {
        $where = array(
            "is_admin" . ($this->getData('mode') == 'users' ? "=" : ">") . "0"
        );

        if ($cond = parent::sqlWhere()) $where[] = $cond;

        return "(" . implode(") AND (", $where) . ")";
    }

}

class PermissionsAction extends Link_Row_AdminManagerAction
{
    function html($row)
    {
        return $row->is_admin == 1 && $_SESSION['user']->is_admin == 2 ? parent::html($row) : '<span class="list-action"></span>';
    }
}

class SuperAdminCol extends AdminManagerCol
{
    function html($row)
    {
        return $row->is_admin > 1 ? '<b class="text-green">Yes</b>' : '<b class="text-red">No</b>';
    }
}
?>

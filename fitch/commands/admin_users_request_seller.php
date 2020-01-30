<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");

class AdminUsersRequestSeller extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        try{
            FJF_BASE::capsuleOpen();
        }
        catch (Exception $e){
            return $e->getMessage();
        }
        catch (Throwable $e){
            return $e->getMessage();
        }

        if($_POST){
            if($_POST['action'] == 'approvex'){
                $user = Illuminate\Database\Capsule\Manager::table('users')
                    ->whereIn('id', $_POST['ids'])
                    ->first();
                if($_POST['command'] == 1){
                    Illuminate\Database\Capsule\Manager::table('users')
                        ->whereIn('id', $_POST['ids'])
                        ->update([
                            'user_type_origin' => 'Seller',
                            'status_upgrade' => '0',
                        ]);
                    MailModel::sendSuccessMessageToNewUser($user);
                }
                else if($_POST['command'] == 0){
                    Illuminate\Database\Capsule\Manager::table('users')
                        ->whereIn('id', $_POST['ids'])
                        ->update([
                            'dealers_license_number' => '',
                        ]);
                    MailModel::sendRejectSellerRequest($user, $_POST['reason']);
                }
            }
        }

        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");
        $this->setToolTitle("Buyers with request to upgrade to seller");
        $manager = new Manager();
        $manager->setOption(array(
            'table' => 'users',
            'default_sort' => 'id'
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
                'id' => 'dealers_license_number',
            ),
            array(
                'id' => 'upgrade_seller_note',
            )
        ));

        $manager->addFilters(array(
            'name',
            'email',
        ));

//        $manager->addRowActions(array(
//            new Link_Row_AdminManagerAction(array(
//                'id' => 'approve',
//                'url' => '/admin/%id%/'
//            ))
//        ));

        $manager->addRowActions(array(
            'approvex',
        ));

        $manager->apply();

        return $this->displayTemplate("admin_users_request_seller.tpl", array(
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
            "status_upgrade=1" ,
        );

        if ($cond = parent::sqlWhere()) $where[] = $cond;

        return "(" . implode(") AND (", $where) . ")";
    }

}

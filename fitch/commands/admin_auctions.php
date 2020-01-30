<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

class AdminAuctions extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Auctions');
        $this->setToolTitleSingular('Auction');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("auctions");
            $manager->hasPositions();
            $manager->hasRevisions();

            $manager->registerPostAction("delete");
            $manager->registerPostAction("toggle");
            $manager->registerPostAction("duplicate", null, null, null, 'title');

            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }

        }//POST

        $GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"] = "id";
        $users = FJF_BASE_RICH::getRecords("users", "", null, null, "id, name");
        $auctionBids = FJF_BASE_RICH::getRecords("auctions_bids", " winning_bid = 1", null, null, "user_id, auction_id, bid_price, winning_bid");
        $manager = new CustomManager();
        $manager->setOption(array(
            'table' => 'auctions'
        ));
        $manager->setData("users", $users);
        $manager->setData("auction_bids", $auctionBids);

        $manager->addFilters(array(
            array(
                'id' => 'vin_number',
                'field' => 'vin_number',
                'label' => 'vin'
            ),
            array(
                'id' => 'name',
                'field' => 'user_id',
                'label' => 'user',
                'type' => 'select',
                'options' => FJF_BASE_RICH::toList($users, "id", "name")
            ),
            array(
                'id' => 'status',
                'type' => 'select',
                'options' => array(
                    1 => 'Active',
                    0 => 'Inactive'
                )
            ),
            array(
                'id' => 'date',
                'field' => 'expiration_date',
                'type' => 'date'
            )
        ));

        $manager->addCols(array(
            new Id_AdminManagerCol,
            new Title_AdminManagerCol(array(
                'id' => 'vin_number'
            )),
            new Title_AdminManagerCol(array(
                'id' => 'user_id',
                'field' => 'name',
                'label' => 'user'
            )),
            new DateTime_AdminManagerCol(array(
                'id' => 'blog_posts_date',
                'field' => 'expiration_date',
                'label' => 'expiration date',
                'action' => 'edit',
                'width' => 1
            )),
            new AuctionInfo_AdminManagerCol,
            new Approved_AdminManagerCol
        ));

        $manager->addCommonActions(array(
            array('id' => 'add', 'label' => 'Add New Item', 'url' => '/admin/auctions/add/')
        ));

        $manager->addBatchActions(array(
            'toggle',
            'duplicate',
            array('id' => 'delete', 'label' => 'Remove'),
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'edit',
                'url' => '/admin/auctions/%id%/'
            )),
            new Toggle_Row_AdminManagerAction,
            'duplicate', 'delete'
        ));

        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_auctions.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        return $this->displayTemplate("admin_auctions.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }
}

class AuctionInfo_AdminManagerCol extends AdminManagerCol
{
    function __construct($data = array())
    {
        parent::__construct(array_merge(array(
            'id' => 'auction_info', 'field' => 'auction_info', 'label' => 'auction info', 'sort_reverse' => true, 'width' => 1
        ), $data));
    }

    function html($row)
    {
        return $row->{$this->field};
    }
}

class CustomManager extends AdminManager
{
    function getRows()
    {
        $rows = parent::getRows();
        $users = $this->getData("users");
        $auctionBids = $this->getData("auction_bids");

        if ($rows) {
            foreach ($rows as $row) {
                $row->name = $users && array_key_exists($row->user_id, $users) ? $users[$row->user_id]->name : "";
                if ($row->auction_status == "Active") {
                    $row->auction_status = "In progress";
                }

                $row->starting_bid_price = FJF_BASE::moneyFormat($row->starting_bid_price);
                $row->buy_now_price = FJF_BASE::moneyFormat($row->buy_now_price);
                $row->reserve_price = FJF_BASE::moneyFormat($row->reserve_price);
                $row->winning_bid = $auctionBids && array_key_exists($row->id, $auctionBids) ? $auctionBids[$row->id]->bid_price : "";
                if ($row->winning_bid != "") {
                    $row->winning_bid = FJF_BASE::moneyFormat($row->winning_bid);
                }

                $row->buyer = $auctionBids && array_key_exists($row->id, $auctionBids) ? $auctionBids[$row->id]->user_id : "";
                $row->buyer_name = $users && array_key_exists($row->buyer, $users) ? $users[$row->buyer]->name : "";

                $row->auction_info = "";
                if ($row->auction_status) {
                    $row->auction_info .= "<b>Auction Status: </b>" . $row->auction_status . "<br/>";
                }
                if ($row->starting_bid_price != 0) {
                    $row->auction_info .= "<b>Minimum Bid: </b>" . $row->starting_bid_price . "<br/>";
                }
                if ($row->buy_now_price != 0) {
                    $row->auction_info .= "<b>Buy Price: </b>" . $row->buy_now_price . "<br/>";
                }
                if ($row->reserve_price != 0) {
                    $row->auction_info .= "<b>Reserve Price: </b>" . $row->reserve_price . "<br/>";
                }
                if ($row->winning_bid != 0) {
                    $row->auction_info .= "<b>Winning Bid: </b>" . $row->winning_bid . "<br/>";
                }
                if ($row->buyer_name != "") {
                    $row->auction_info .= "<b>Buyer: </b>" . $row->buyer_name;
                }
            }
        }

        return $rows;
    }
}

?>
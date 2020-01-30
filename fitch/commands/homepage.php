<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class Homepage extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
    }

    function execute()
    {
        /*if (SessionModel::isUser() && SessionModel::getUserType()) {
            $userType = SessionModel::getUserType();
            if ($userType == "Seller") {
                FJF_BASE::redirect("/account/");
            } elseif ($userType == "Buyer") {
                FJF_BASE::redirect("/auctions/");
            }
        }*/

        $this->pageModel->loadSettings("homepage");
        $settings = $this->pageModel->getSettings();
        if (is_object($settings) && $settings->repeating_fieldgroups != "") {
            $settings->repeating_fieldgroups = json_decode($settings->repeating_fieldgroups);
        }

        $upcomingAuctions = RecordsModel::getAllAuctions("a.auction_status = 'Active' AND a.expiration_date > NOW()", "", 3, "a.expiration_date ASC", null);
        if (!empty($upcomingAuctions)) {
            foreach ($upcomingAuctions as $auction) {
                $auction->time_end = strtotime($auction->expiration_date) - time();
            }
        }

        $upcomingAuctionsCount = FJF_BASE_RICH::countFrom("auctions", "status = 1 AND approved = 1 AND auction_status = 'Active' AND expiration_date > NOW()");

        return $this->displayTemplate("homepage.tpl", array(
            "settings" => $settings,
            "auctions" => $upcomingAuctions,
            "upcoming_auctions_count" => $upcomingAuctionsCount
        ));
    }

}

?>
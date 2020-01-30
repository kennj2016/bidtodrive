<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class News extends FJF_CMD
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
        $this->pageModel->loadSettings("blog");
        $settings = $this->pageModel->getSettings();
        $categories = FJF_BASE_RICH::getRecords("blog_categories", "status=1 AND approved=1");

        $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
        if ($page == 1) {
            //$limit = 21;
            $limit = 21;
        } else {
            //$limit = 20;
            $limit = 20;
        }
        if ($page != 1) {
            $offset = $limit * ($page - 1) + 1;
        } else {
            $offset = $limit * ($page - 1);
        }
        $sqlLimit = $offset . ", " . $limit;
        $where = "1";
        $keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
        $categoryID = isset($_REQUEST["category_id"]) ? trim($_REQUEST["category_id"]) : "";
        $sort = isset($_REQUEST["sort"]) ? trim($_REQUEST["sort"]) : "date";
        $categoryUrlTitle = isset($_REQUEST["category_url_title"]) ? trim($_REQUEST["category_url_title"]) : "";
        $authorUrlTitle = isset($_REQUEST["author_url_title"]) ? trim($_REQUEST["author_url_title"]) : "";
        $order = "b.datetime_publish DESC";
        if ($sort == "category") {
            $order = " bc.title";
        }
        if ($categoryUrlTitle) {
            $where .= " AND (bc.url_title = '" . $categoryUrlTitle . "')";
            $category = FJF_BASE_RICH::getRecordBy("blog_categories", $categoryUrlTitle, "url_title");
            $settings->breadcrumbs2 = $category ? "Category " . $category->title : "";
            $settings->selected_category = $category ? $category->id : "";
        }
        if ($authorUrlTitle) {
            $where .= " AND (u.url_title = '" . $authorUrlTitle . "')";
            $user = FJF_BASE_RICH::getRecordBy("users", $authorUrlTitle, "url_title");
            $settings->breadcrumbs2 = $user ? "Author " . $user->name : "";
        }
        if ($keyword) {
            $where .= " AND (b.title LIKE '%" . $keyword . "%' OR b.description LIKE '%" . $keyword . "%' OR bc.title LIKE '%" . $keyword . "%' OR u.name LIKE '%" . $keyword . "%')";
        }
        if ($categoryID) {
            $where .= " AND (b.category_id=" . $categoryID . ")";
        }
        $countRecords = RecordsModel::getNewsCount($where);

        $records = $countRecords ? RecordsModel::getNews($where, $sqlLimit, $order) : null;
        $countPages = 0;
        if ($page == 1) {
            $countPages = ceil(($countRecords - 1) / ($limit - 1));
        } else {
            $countPages = ceil($countRecords / $limit);
        }
        if ($this->isAjax()) {
            $data = array();
            $data["html"] = $this->fetchTemplate("news_list.tpl", array(
                "settings" => $settings,
                "categories" => $categories,
                "records" => $records,
                "page" => $page,
                "count_pages" => $countPages
            ));
            echo json_encode($data);
            return true;
        }
        return $this->displayTemplate("news.tpl", array(
            "settings" => $settings,
            "categories" => $categories,
            "records" => $records,
            "page" => $page,
            "count_pages" => $countPages
        ));
    }

}

?>
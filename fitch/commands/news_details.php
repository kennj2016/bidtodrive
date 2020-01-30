<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class NewsDetails extends FJF_CMD
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
        $urlTitle = isset($_REQUEST["url_title"]) ? trim($_REQUEST["url_title"]) : "";
        $record = RecordsModel::getNew($urlTitle);
        if (!$record) {
            FJF_BASE::redirect("/news/");
        }

        if (!$record->meta_title) $record->meta_title = $record->title;
        if (!$record->meta_title) $record->meta_title = $settings->meta_title;
        if (!$record->meta_keywords) $record->meta_keywords = $settings->meta_keywords;
        if (!$record->meta_description) $record->meta_description = $settings->meta_description;
        if ($record->image) {
            $settings->hero_image = $record->image;
        }
        $this->pageModel->extractMetadata($record);

        $where = "b.id<>" . $record->id . " AND b.category_id=" . $record->category_id;
        $recentNews = RecordsModel::getNews($where, 2);
        return $this->displayTemplate("news_details.tpl", array(
            "settings" => $settings,
            "record" => $record,
            "recent_news" => $recentNews
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminHomepageSettingsAutosave extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        $data = array();
        $hasError = false;
        $status = "";

        if (!$this->sessionModel->hasAdminPermissions()) {
            $hasError = true;
            $status = "Access denied.";
        } else {
            $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'homepage');

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    /* Hero */
                    $record->hero_title = isset($_POST["hero_title"]) ? trim($_POST["hero_title"]) : "";
                    $record->hero_subtitle = isset($_POST["hero_subtitle"]) ? trim($_POST["hero_subtitle"]) : "";
                    $record->hero_image = isset($_POST["hero_image"]) ? trim($_POST["hero_image"]) : "";

                    /* Buyer Sign Up CTA */
                    $record->buyer_cta_title = isset($_POST["buyer_cta_title"]) ? trim($_POST["buyer_cta_title"]) : "";
                    $record->buyer_cta_subtitle = isset($_POST["buyer_cta_subtitle"]) ? trim($_POST["buyer_cta_subtitle"]) : "";
                    $record->buyer_cta_background_image = isset($_POST["buyer_cta_background_image"]) ? trim($_POST["buyer_cta_background_image"]) : "";
                    $record->buyer_cta_icon = isset($_POST["buyer_cta_icon"]) ? trim($_POST["buyer_cta_icon"]) : "";
                    $record->buyer_cta_button_text = isset($_POST["buyer_cta_button_text"]) ? trim($_POST["buyer_cta_button_text"]) : "";

                    /* Seller Sign Up CTA */
                    $record->seller_cta_title = isset($_POST["seller_cta_title"]) ? trim($_POST["seller_cta_title"]) : "";
                    $record->seller_cta_subtitle = isset($_POST["seller_cta_subtitle"]) ? trim($_POST["seller_cta_subtitle"]) : "";
                    $record->seller_cta_background_image = isset($_POST["seller_cta_background_image"]) ? trim($_POST["seller_cta_background_image"]) : "";
                    $record->seller_cta_icon = isset($_POST["seller_cta_icon"]) ? trim($_POST["seller_cta_icon"]) : "";
                    $record->seller_cta_button_text = isset($_POST["seller_cta_button_text"]) ? trim($_POST["seller_cta_button_text"]) : "";

                    /* How It Works */
                    $record->repeating_fieldgroups = array();
                    $postArr = isset($_POST['repeating_fieldgroups']) && is_array($_POST['repeating_fieldgroups']) ? $_POST['repeating_fieldgroups'] : array();
                    foreach ($postArr as $k => $post) {
                        $item = array(
                            'title' => isset($post['title']) ? trim($post['title']) : '',
                            'subtitle' => isset($post['subtitle']) ? trim($post['subtitle']) : '',
                            'background_image' => isset($post['background_image']) ? trim($post['background_image']) : '',
                            'icon' => isset($post['icon']) ? trim($post['icon']) : ''
                        );
                        if (!implode("", $item)) continue;
                        array_push($record->repeating_fieldgroups, $item);
                    }
                    $record->repeating_fieldgroups = json_encode($record->repeating_fieldgroups);

                    /* Current Auctions */
                    $record->current_auctions_title = isset($_POST["current_auctions_title"]) ? trim($_POST["current_auctions_title"]) : "";
                    $record->current_auctions_subtitle = isset($_POST["current_auctions_subtitle"]) ? trim($_POST["current_auctions_subtitle"]) : "";

                    $record->meta_title = isset($_POST["meta_title"]) ? trim($_POST["meta_title"]) : "";
                    $record->meta_keywords = isset($_POST["meta_keywords"]) ? trim($_POST["meta_keywords"]) : "";
                    $record->meta_description = isset($_POST["meta_description"]) ? trim($_POST["meta_description"]) : "";

                    if ($revision = $editor->autosave()) {
                        $data['revision'] = $revision;
                    } else {
                        $hasError = true;
                        $status = "Autosave was failed.";
                    }

                } else {

                    $data['revisions'] = $editor->getRevisions();

                }
            }
        }

        exit(json_encode(
            array('has_error' => $hasError, 'status' => $status) + $data
        ));
    }

}

?>
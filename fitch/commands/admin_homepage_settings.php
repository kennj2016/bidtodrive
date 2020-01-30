<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminHomepageSettings extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Homepage: Settings');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");
        //include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");

        $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'homepage');
        $record = $editor->loadRecord();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {
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
            }

            if (!$hasError) {
                if ($editor->$method()) {
                    $status = "Data was saved successfully.";
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }//POST

        return $this->displayTemplate("admin_homepage_settings.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminAboutSettings extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('About: Settings');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");
        //include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_editor.php");

        $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'about');
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

                /* Intro */
                $record->intro_title = isset($_POST["intro_title"]) ? trim($_POST["intro_title"]) : "";
                $record->intro_subtitle = isset($_POST["intro_subtitle"]) ? trim($_POST["intro_subtitle"]) : "";
                $record->intro_image = isset($_POST["intro_image"]) ? trim($_POST["intro_image"]) : "";

                /* Key Features */
                $record->key_features_title = isset($_POST["key_features_title"]) ? trim($_POST["key_features_title"]) : "";
                $record->key_features_intro_text = isset($_POST["key_features_intro_text"]) ? trim($_POST["key_features_intro_text"]) : "";
                $record->key_features_background_image = isset($_POST["key_features_background_image"]) ? trim($_POST["key_features_background_image"]) : "";
                $record->buckets = array();
                $postArr = isset($_POST['buckets']) && is_array($_POST['buckets']) ? $_POST['buckets'] : array();
                foreach ($postArr as $k => $post) {
                    $item = array(
                        'title' => isset($post['title']) ? trim($post['title']) : '',
                        'subtitle' => isset($post['subtitle']) ? trim($post['subtitle']) : '',
                        'icon' => isset($post['icon']) ? trim($post['icon']) : '',
                        'button_text' => isset($post['button_text']) ? trim($post['button_text']) : '',
                        'button_url' => isset($post['button_url']) ? trim($post['button_url']) : ''
                    );
                    if (!implode("", $item)) continue;
                    array_push($record->buckets, $item);
                }
                $record->buckets = json_encode($record->buckets);

                /* How It Works */
                $record->how_it_works_title = isset($_POST["how_it_works_title"]) ? trim($_POST["how_it_works_title"]) : "";
                $record->steps = array();
                $postArr = isset($_POST['steps']) && is_array($_POST['steps']) ? $_POST['steps'] : array();
                foreach ($postArr as $k => $post) {
                    $item = array(
                        'title' => isset($post['title']) ? trim($post['title']) : '',
                        'description' => isset($post['description']) ? trim($post['description']) : '',
                        'icon' => isset($post['icon']) ? trim($post['icon']) : ''
                    );
                    if (!implode("", $item)) continue;
                    array_push($record->steps, $item);
                }
                $record->steps = json_encode($record->steps);

                /* Leadership */
                $record->leadership_title = isset($_POST["leadership_title"]) ? trim($_POST["leadership_title"]) : "";
                $record->leadership_image = isset($_POST["leadership_image"]) ? trim($_POST["leadership_image"]) : "";
                $record->leadership_description = isset($_POST["leadership_description"]) ? trim($_POST["leadership_description"]) : "";

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

        return $this->displayTemplate("admin_about_settings.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record
        ));
    }

}

?>
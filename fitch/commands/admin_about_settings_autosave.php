<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_site_data_revisions_editor.php");

class AdminAboutSettingsAutosave extends FJF_CMD
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
            $editor = new AdminSiteDataRevisionsEditor('pages_settings', 'about');

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
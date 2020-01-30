<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

class AdminSiteMediaEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Site Media');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if (!$header["return"]) {
            $header["return"] = "/admin/site_media/";
        }

        $editor = new AdminEditModel(array(
            'table' => 'site_media_folders'
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect($header["return"]);

        $types = array("common", "images", "svg");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";

            if (!$record->id) {
                $record->label = $this->generateLabel(isset($_POST["label"]) && $_POST["label"] ? trim($_POST["label"]) : $record->title);
                $record->type = isset($_POST["type"]) ? trim($_POST["type"]) : "";
                $record->readonly = isset($_POST["readonly"]) ? intval($_POST["readonly"]) : 0;
                if ($record->type == 'images') {
                    $record->options = new stdClass;
                    $record->options->sizes = array();
                    $postSizes = isset($_POST["sizes"]) ? $_POST["sizes"] : array();
                    foreach ($postSizes as $postSize) {
                        $size = array(
                            'title' => trim($postSize['title']),
                            'label' => $this->generateLabel($postSize['label'] ? $postSize['label'] : $postSize['title']),
                            'width' => intval($postSize['width']),
                            'height' => intval($postSize['height']),
                            'save_aspect_ratio' => isset($postSize['save_aspect_ratio']),
                            'enlarge_small_images' => isset($postSize['enlarge_small_images']),
                            'fit_small_images' => isset($postSize['fit_small_images']),
                            'fit_large_images' => isset($postSize['fit_large_images']),
                            'background_color' => trim($postSize['background_color'])
                        );
                        if ($size['title'] || $size['label'] || $size['width'] > 0 || $size['height'] > 0) {
                            $record->options->sizes[] = $size;
                            $i = count($record->options->sizes);
                            if (!$size['title']) {
                                $hasError = true;
                                $status .= "Size #" . $i . ": Title is missing.\n";
                            }
                            if (!$size['label']) {
                                $hasError = true;
                                $status .= "Size #" . $i . ": Label is missing.\n";
                            }
                            if ($size['width'] <= 0) {
                                $hasError = true;
                                $status .= "Size #" . $i . ": Width is missing.\n";
                            }
                            if ($size['height'] <= 0) {
                                $hasError = true;
                                $status .= "Size #" . $i . ": Height is missing.\n";
                            }
                        }
                    }
                    $record->options = json_encode($record->options);
                }
            }

            if ($messages = $editor->validate(array(
                'title' => array('required' => true)
            ))) {
                $hasError = true;
                $status = implode("\n", $messages);
            }

            if (!$hasError) {
                if ($editor->saveRecord()) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/site_media/" . $record->id . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->addParentBreadCrumb("site_media");
        $this->setRecord($record);

        $record->options = isset($record->options) ? json_decode($record->options) : new stdClass;

        return $this->displayTemplate("admin_site_media_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "types" => $types
        ));
    }

    function generateLabel($str)
    {
        return trim(preg_replace("/[^\da-z_-]/", "-", strtolower(trim($str))), "-");
    }//generateLabel

}

?>
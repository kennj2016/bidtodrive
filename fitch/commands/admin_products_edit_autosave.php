<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminProductsEditAutosave extends FJF_CMD
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
        } elseif (!isset($_GET['id']) || !trim($_GET['id'])) {
            $hasError = true;
            $status = "Invalid ID.";
        } else {
            $editor = new AdminEditRevisionsModel(array(
                'table' => 'products'
            ));

            if (!$record = $editor->loadRecord()) {
                $hasError = true;
                $status = "Record not found.";
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $categoryField = new AdminAutocompleteField('category_id', "product_categories");
                    $record->category_id = $categoryField->getValue();

                    $record->sku = isset($_POST["sku"]) ? trim($_POST["sku"]) : "";
                    $record->title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
                    $record->description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
                    $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
                    $record->price = isset($_POST["price"]) ? trim($_POST["price"]) : "";

                    $record->images = array();
                    $postArr = isset($_POST['images']) && is_array($_POST['images']) ? $_POST['images'] : array();
                    foreach ($postArr as $post) {
                        $item = array(
                            'title' => isset($post['title']) ? trim($post['title']) : '',
                            'image' => isset($post['image']) ? trim($post['image']) : ''
                        );
                        if (!implode("", $item)) continue;
                        array_push($record->images, $item);
                    }
                    $record->images = json_encode($record->images);

                    $record->repeating_fieldgroup = array();
                    $postArr = isset($_POST['repeating_fieldgroup']) && is_array($_POST['repeating_fieldgroup']) ? $_POST['repeating_fieldgroup'] : array();
                    foreach ($postArr as $post) {
                        $item = array(
                            'title' => isset($post['title']) ? trim($post['title']) : '',
                            'description' => isset($post['description']) ? trim($post['description']) : ''
                        );
                        if (!implode("", $item)) continue;
                        array_push($record->repeating_fieldgroup, $item);
                    }
                    $record->repeating_fieldgroup = json_encode($record->repeating_fieldgroup);

                    $record->variations = array();
                    $postArr = isset($_POST['variations']) && is_array($_POST['variations']) ? $_POST['variations'] : array();
                    foreach ($postArr as $k => $post) {
                        $item = array(
                            'title' => isset($post['title']) ? trim($post['title']) : '',
                            'description' => isset($post['description']) ? trim($post['description']) : '',
                            'sku' => isset($post['sku']) ? trim($post['sku']) : '',
                            'price' => isset($post['price']) ? trim($post['price']) : '',
                            'image' => isset($post['image']) ? trim($post['image']) : '',
                            'status' => 1,
                            'remaining' => 0,
                            'sold' => 0,
                            'amount' => 0,
                            'id' => $k + 1
                        );
                        if (!implode("", $item)) continue;
                        array_push($record->variations, $item);
                    }
                    $record->variations = json_encode($record->variations);

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
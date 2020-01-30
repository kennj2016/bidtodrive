<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_revisions_model.php");

class AdminProductsEdit extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Products');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $editor = new AdminEditRevisionsModel(array(
            'table' => 'products',
            'title_field' => 'name',
            'positions' => true
        ));

        if (!$record = $editor->loadRecord()) FJF_BASE::redirect("/admin/products/");

        if (!$record->id) {
            $record->images = '[]';
            $record->images_pv = '[]';
            $record->repeating_fieldgroup = '[]';
            $record->variations = '[]';
        }

        $categoryField = new AdminAutocompleteField('category_id', "product_categories");


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $submit = isset($_POST['submit']) ? strtolower(trim($_POST['submit'])) : null;
            if (strpos($submit, 'publish') !== false && $this->sessionModel->isSuperAdmin()) $method = "saveAndPublish";
            else if (strpos($submit, 'approval') !== false) $method = "submitForApproval";
            else if ($this->sessionModel->isSuperAdmin() && strpos($submit, 'approve') !== false
                && isset($record->revision_tag) && $record->revision_tag == 'pending') $method = "approve";
            else $method = "saveForLater";

            if ($method != "approve") {

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

                    if ($messages = $editor->validate(array(
                        'title' => array('label' => 'Title', 'required' => true),
                        'image' => array('label' => 'Image', 'required' => true)
                    ), (object)$item)) {
                        $hasError = true;
                        $status .= "Image #" . count($record->images) . ": " . implode("\n", $messages) . "\n";
                    }
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

                    if ($messages = $editor->validate(array(
                        'title' => array('label' => 'Title', 'required' => true),
                        'description' => array('label' => 'Description', 'required' => true)
                    ), (object)$item)) {
                        $hasError = true;
                        $status .= "Repeating Fieldgroup #" . count($record->repeating_fieldgroup) . ": " . implode("\n", $messages) . "\n";
                    }
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
                        'statuses' => 1,
                        'remaining' => 0,
                        'sold' => 0,
                        'amount' => 0,
                        'id' => $k + 1
                    );
                    if (!implode("", $item)) continue;
                    array_push($record->variations, $item);

                    if ($messages = $editor->validate(array(
                        'sku' => array('label' => 'Sku', 'required' => true),
                        'title' => array('label' => 'Title', 'required' => true),
                        'description' => array('label' => 'Description', 'required' => true)
                    ), (object)$item)) {
                        $hasError = true;
                        $status .= "Variations #" . count($record->variations) . ": " . implode("\n", $messages) . "\n";
                    }
                }
                $record->variations = json_encode($record->variations);

                if ($messages = $editor->validate(array(
                    'category_id' => array('label' => 'Category', 'required' => true),
                    'sku' => array('label' => 'SKU', 'required' => true),
                    'title' => array('label' => 'Title', 'required' => true),
                    'price' => array('label' => 'Price', 'required' => true, 'format' => 'usfloat')
                ))) {
                    $hasError = true;
                    $status .= implode("\n", $messages);
                }

            }
            if (!$hasError) {
                if ($editor->$method()) FJF_BASE::redirect("/admin/products/");
                else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }

        }//POST

        $this->setRecord($record);
        $this->addParentBreadCrumb('products');

        if (isset($record->category_id)) $categoryField->setValue($record->category_id);

        return $this->displayTemplate("admin_products_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "category_field" => $categoryField
        ));
    }

}

?>
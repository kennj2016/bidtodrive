<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");

class AdminSiteMediaApi extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    var $has_error = false;
    var $messages = array();
    var $data = null;

    function execute()
    {

        $method_name = "action_" . ($_GET['action'] ? $_GET['action'] : '');
        $isRWMethod = in_array($method_name, array(
            "action_get_folder",
            "action_get_folders",
            "action_get_file",
            "action_view_folder",
            "action_upload_file",
            "action_copy_file",
            "action_crop"
        ));

        if (!SessionModel::isAdmin()) $this->message("Access denied.");
        elseif (!method_exists($this, $method_name)) $this->message("Invalid action.");
        elseif (!SessionModel::hasAdminPermissions() && !$isRWMethod) $this->message("Access denied for this method.");
        else {
            try {
                $this->$method_name(isset($_REQUEST['parameters']) ? $_REQUEST['parameters'] : null);
            } catch (Exception $e) {
                $this->message($e->getMessage());
            }
        }

        $this->sendResponse();
    }

    function message($message, $error = true)
    {
        if ($error) $this->has_error = true;
        $this->messages[] = trim($message);
    }

    function data($data = null)
    {
        $this->data = $data;
    }

    function sendResponse()
    {
        $response = array(
            'has_error' => $this->has_error,
            'status' => implode("\n", $this->messages)
        );
        if ($this->data !== null) $response['data'] = $this->data;
        exit(json_encode($response));
    }

    function action_remove_folder($folderId)
    {

        if (!$folder = SiteMediaModel::getFolder($folderId)) {
            $this->message("Folder not found.");
        } elseif ($folder->readonly) {
            $this->message("This folder is readonly.");
        } elseif (!SiteMediaModel::removeFolder($folder)) {
            $this->message("Can't delete this folder.");
        }

    }//action_remove_folder

    function action_remove_file($fileId)
    {

        if (!$file = SiteMediaModel::getFile($fileId)) {
            $this->message("File not found.");
        } elseif (!SiteMediaModel::removeFile($file)) {
            $this->message("Can't delete this folder.");
        }

    }//action_remove_file

    function action_get_folder($folderId)
    {

        if (!$folder = SiteMediaModel::getFolder($folderId)) {
            $this->message("Folder not found.");
        } else {
            $this->data($folder);
        }

    }//action_get_folder

    function action_get_folders()
    {
        $this->data(SiteMediaModel::getFolders());
    }//action_get_folders

    function action_get_file($fileId)
    {

        if (!$file = SiteMediaModel::getFile($fileId)) {
            $this->message("File not found.");
        } else {
            $this->data($file);
        }

    }//action_get_file

    function action_view_folder($folderId)
    {
        $this->data(SiteMediaModel::getFiles($folderId));
    }//action_view_folder

    function action_upload_file($folderId)
    {
        if (!$folder = SiteMediaModel::getFolder($folderId)) {
            $this->message("Folder not found.");
        } elseif (!$file = SiteMediaModel::uploadFile($folder, 'file')) {
            $this->message("Can't uplaod file to this folder.");
        } else {
            $this->data($file);
        }
    }//action_upload_file

    function action_copy_file($params)
    {
        list($fileId, $folderId) = $params;
        if (!$file = SiteMediaModel::getFile($fileId)) {
            $this->message("File not found.");
        } elseif (!$folder = SiteMediaModel::getFolder($folderId)) {
            $this->message("Folder not found.");
        } elseif (!$copy = SiteMediaModel::copyFile($file, $folder)) {
            $this->message("Can't copy file to this folder.");
        } else {
            $this->data($copy);
        }
    }//action_copy_file

    function action_crop($params)
    {
        list($fileId, $sizeId, $coords, $size) = $params;
        if (!$file = SiteMediaModel::getFile($fileId)) {
            $this->message("File not found.");
        } elseif (!$folder = SiteMediaModel::getFolder($file->folder_id)) {
            $this->message("Folder not found.");
        } elseif (!$sizeId) {
            $this->message("Size is missing.");
        } elseif (!$coords || !$size) {
            $this->message("Coords is missing.");
        } else {
            SiteMediaModel::cropImage($folder, $file, $sizeId, $coords, $size);
        }
    }//action_crop

}

?>
<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

class AdminSiteMediaCrop extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        if (!SessionModel::hasAdminPermissions()) exit("Access denied.");

        $file = isset($_GET['id']) ? SiteMediaModel::getFile($_GET['id']) : null;
        if (!$file) exit("File not found.");

        if (!in_array($file->extension, FilesModel::$extensions_images)) exit("File is not an image.");

        $folder = SiteMediaModel::getFolder($file->folder_id);
        if (!$folder) exit("Folder not found.");

        $sizes = SiteMediaModel::getFolderCropSizes($folder);

        $this->displayTemplate("admin_site_media_crop.tpl", array(
            "file" => $file,
            "sizes" => $sizes
        ));
    }

}

?>
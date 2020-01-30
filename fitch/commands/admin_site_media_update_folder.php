<?php

error_reporting(FJF_SERVER == 'live' ? 0 : E_ALL);
ini_set('display_errors', FJF_SERVER == 'live' ? '0' : '1');

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

class AdminSiteMediaUpdateFolder extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    function execute()
    {
        if (!SessionModel::hasAdminPermissions()) exit("Access denied.");

        $folder = isset($_GET['id']) ? SiteMediaModel::getFolder($_GET['id']) : null;
        if (!$folder) exit("Folder not found.");

        if ($folder->type != 'images') {
            exit("Update is not necessary.");
        }

        $files = SiteMediaModel::getFiles($folder->id);
        //$sizes = array("title" => "Bill Detail", "label" => "bd", "width" => 370, "height" => 190, "save_aspect_ratio" => "", "enlarge_small_images" => 1, "fit_small_images" => "", "fit_large_images" => "", "background_color" => "");
        //$sizes = array((object) $sizes);
        $sizes = SiteMediaModel::getFolderImageSizes($folder);

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");

        set_time_limit(120);

        if ($files && $sizes) {
            foreach ($files as $file) {
                $editor = new AdminEditModel(array(
                    'table' => 'site_media_files',
                    'id' => $file->id
                ));
                $file = $editor->loadRecord();
                SiteMediaModel::generateImageSizes($file, $sizes);
                echo "#" . $file->id . ": ";
                if ($editor->saveRecord()) {
                    SiteMediaModel::saveCacheData(
                        SiteMediaModel::getCacheFilename($file->id),
                        SiteMediaModel::getFileData($file)
                    );
                    echo "saved";
                } else {
                    echo "saving erorr";
                }
                echo "<br />";
                unset($editor);
            }
        }
        exit('Done');
    }
}

?>
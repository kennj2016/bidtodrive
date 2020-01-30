<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/common_records_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");

class ViewLicense extends FJF_CMD
{
    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->page = new PageModel();
    }

    function execute()
    {
        $licenseFile = isset($_GET["license"]) ? $_GET["license"] : null;
        $size = isset($_GET["size"]) ? $_GET["size"] : "_orig";
        $isLoggedIn = SessionModel::isUser();
        $isAdmin = SessionModel::isAdmin();
        $loggedUserID = $isLoggedIn ? SessionModel::loggedUserID() : 0;

        $data = null;
        $file = null;
        $folderID = 0;

        if ($licenseFile) {
            $fileInfo = FJF_BASE_RICH::getRecord("site_media_files", "name_new = 'LICENSE_ID'", array("LICENSE_ID" => $licenseFile));
            $userWhoUploadedImage = (is_object($fileInfo)) ? FJF_BASE_RICH::getRecord("users", "drivers_license_photo = 'IMAGE_ID' OR dealers_license_photo = 'IMAGE_ID' OR profile_photo = 'IMAGE_ID'", array("IMAGE_ID" => $fileInfo->id)) : null;

            if (is_object($fileInfo)) {
                $file = $fileInfo->id;
                $folderID = $fileInfo->folder_id;
            }

            if ($file && $folderID == 8 && ((is_object($userWhoUploadedImage) && $loggedUserID == $userWhoUploadedImage->id) || $isAdmin)) {
                $cacheFile = SiteMediaModel::getCacheFilename($file);
                if (file_exists($cacheFile)) {
                    $data = SiteMediaModel::getCacheData($cacheFile);
                } else {
                    if ($file = FJF_BASE_RICH::getRecordBy("site_media_files", $file)) {
                        $data = SiteMediaModel::getFileData($file);
                    }
                }

                if ($data) {
                    $licenseFilePath = $_SERVER["DOCUMENT_ROOT"] . "/media/" . $data[0] . "/" . $size . "/" . $data[1];
                    header("Content-Type: image/jpeg");
                    header('Content-Disposition: inline; filename="' . $file . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Accept-Ranges: bytes');
                    @readfile($licenseFilePath);
                    exit;
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                exit("Not Found.");
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            exit("Not Found.");
        }
    }

}

?>
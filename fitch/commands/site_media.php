<?php

class SiteMedia extends FJF_CMD
{

    function execute()
    {

        $file = isset($_GET['file']) ? $_GET['file'] : null;
        $size = isset($_GET['size']) ? $_GET['size'] : '_orig';
        if ($size == 'l') $size = 'm';
        $download = $size == "download";
        if ($download) $size = "_orig";
        $data = null;

        if ($file) {

            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");

            $cacheFile = SiteMediaModel::getCacheFilename($file);

            if (file_exists($cacheFile)) {
                $data = SiteMediaModel::getCacheData($cacheFile);
            } else {

                $sql = "SELECT name_new, folder_id, datetime_update";
                $sql .= " FROM site_media_files";
                $sql .= " WHERE id='FILE_ID'";
                $sql .= " LIMIT 1";
                if ($file = FJF_BASE_RICH::selectRecords($sql, array('FILE_ID' => $file), true)) {
                    $data = SiteMediaModel::getFileData($file);
                }

                SiteMediaModel::saveCacheData($cacheFile, $data);
            }
        }

        if ($data) {

            $q = array();
            if ($size != '_orig' && $data[2]) $q["t"] = $data[2];
            if ($download) $q["download"] = 1;
            $q = $q ? "?" . http_build_query($q) : "";

            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/common_records_model.php");
            if ($value = CommonRecordsModel::getSiteVar("cdn_server")) {
                $cdnServer = str_replace(array("http:", "https:"), "", $value);
            } else {
                $cdnServer = $_SERVER["SERVER_NAME"];
            }
            $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https" : "http";
            $staticServer = $scheme . "://" . trim($cdnServer, "/");

            header("HTTP/1.1 303 See Other");
            header("Location: " . $staticServer . "/media/" . $data[0] . "/" . $size . "/" . $data[1] . $q);
            exit;
        }

        header("HTTP/1.0 404 Not Found");
        exit;
    }

}

?>
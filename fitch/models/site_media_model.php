<?php

class SiteMediaModel
{

    const ORIG_PATH = '_orig';
    const THUMBS_PATH = '_thumbs';

    static function getFolders()
    {
        $folders = FJF_BASE_RICH::getRecords(
            "site_media_folders",
            "TRUE ORDER BY title",
            null,
            null,
            "id, title, label, type, readonly, options"
        );
        return $folders ? $folders : array();
    }

    static function getFolder($id)
    {
        return FJF_BASE_RICH::getRecords(
            "site_media_folders",
            (is_numeric($id) ? 'id' : 'label') . "='FOLDER_ID' LIMIT 1",
            array('FOLDER_ID' => $id),
            true,
            "id, title, label, type, readonly, options"
        );
    }//getFolder

    static function removeFolder($folder)
    {
        if ($result = FJF_BASE_RICH::deleteRecords(
            "site_media_folders",
            "id='ID_VAL' AND readonly=0",
            array('ID_VAL' => $folder->id)
        )) {
            FJF_BASE_RICH::deleteRecords("site_media_files", "folder_id='ID_VAL'", array('ID_VAL' => $folder->id));
            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");
            FilesModel::removeDirectory(SiteMediaModel::getFolderPath($folder));
        }
        return $result;
    }//removeFolder

    static function getFiles($folderId)
    {
        $sql = "SELECT f.id, f.folder_id, f.name_orig, f.name_new, f.size, f.extension, f.mime_type, f.datetime_create";
        $sql .= " FROM site_media_files f";
        $sql .= " LEFT JOIN site_media_folders d ON f.folder_id=d.id";
        $sql .= " WHERE " . (is_numeric($folderId) ? 'd.id' : 'd.label') . "='FOLDER_ID'";
        $sql .= " ORDER BY id";
        $files = FJF_BASE_RICH::selectRecords($sql, array('FOLDER_ID' => $folderId));
        return $files ? $files : array();
    }//getFiles

    static function getFile($fileId)
    {
        $sql = "SELECT id, folder_id, name_orig, name_new, size, extension, mime_type, datetime_create";
        $sql .= " FROM site_media_files";
        $sql .= " WHERE id='FILE_ID'";
        $sql .= " ORDER BY id";
        $sql .= " LIMIT 1";
        return FJF_BASE_RICH::selectRecords($sql, array('FILE_ID' => $fileId), true);
    }//getFile

    static function removeFile($file, $folder = null)
    {
        if ($result = FJF_BASE_RICH::deleteRecord("site_media_files", $file->id)) {
            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

            FilesModel::removeFile(SiteMediaModel::getFilePath($file));

            if (!$folder) $folder = SiteMediaModel::getFolder($file->folder_id);
            if ($folder) {
                foreach (SiteMediaModel::getFolderImageSizes($folder) as $sizeOptions) {
                    FilesModel::removeFile(SiteMediaModel::getFilePath($file, $sizeOptions->label));
                }
            }

        }
        return $result;
    }//removeFile

    static function getMediaPath()
    {
        return $_SERVER["DOCUMENT_ROOT"] . DIR_SEP . "media";
    }//getMediaPath

    static function getFolderPath($folder, $sub = null)
    {
        $result = SiteMediaModel::getMediaPath() . DIR_SEP . (is_object($folder) ? $folder->id : $folder);
        if ($sub) $result .= DIR_SEP . $sub;
        return $result;
    }//getFolderPath

    static function getFilePath($file, $dir = null)
    {
        return SiteMediaModel::getFolderPath($file->folder_id, $dir ? $dir : SiteMediaModel::ORIG_PATH)
            . DIR_SEP . $file->name_new;
    }//getFilePath

    static function getFolderOptions($folder)
    {
        if (is_array($folder->options)) return $folder->options;
        elseif (is_string($folder->options)) return json_decode($folder->options);
        else return array();
    }//getFolderOptions

    static function getFolderImageSizes($folder)
    {
        $sizes = array((object)array(
            'label' => SiteMediaModel::THUMBS_PATH,
            'width' => 134,
            'height' => 134,
            'save_aspect_ratio' => true
        ));
        if ($folder->type == 'images') {
            $options = SiteMediaModel::getFolderOptions($folder);
            if (isset($options->sizes) && is_array($options->sizes)) $sizes = array_merge($sizes, $options->sizes);
        }
        return $sizes;
    }//getFolderImageSizes

    static function getFolderCropSizes($folder)
    {
        $sizes = array();
        $ratios = array();

        $options = SiteMediaModel::getFolderOptions($folder);
        if ($options && $options->sizes) foreach ($options->sizes as $size) {
            $width = (int)$size->width;
            $height = (int)$size->height;

            $s = $width . 'x' . $height;
            $id = $s . '-' . $size->label;

            $sizes[$id] = (object)array(
                'id' => $id,
                'title' => $size->title . " [" . $s . "]",
                'sizes' => array($size)
            );

            $gcd = gmp_intval(gmp_gcd($width, $height));
            $ratio = ($width / $gcd) . ":" . ($height / $gcd);

            if (!array_key_exists($ratio, $ratios)) {
                $ratios[$ratio] = (object)array(
                    'id' => $ratio,
                    'title' => "Ratio " . $ratio,
                    'sizes' => array()
                );
            }
            $ratios[$ratio]->sizes[] = $size;
        }

        foreach ($ratios as $ratio) {
            if (count($ratio->sizes) > 1) $sizes[$ratio->id] = $ratio;
        }

        return $sizes;
    }//getFolderCropSizes

    static function getFolderExtensions($folder)
    {
        switch ($folder->type == 'images') {
            case 'images':
                $extensions = FilesModel::$extensions_images;
                break;
            case 'svg':
                $extensions = array("svg");
                break;
            default:
                $extensions = null;
                break;
        }
        return $extensions;
    }

    static function uploadFile($folder, $file = 'file')
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

        if ($postFile = FilesModel::getPostFile($file)) {
            $uploadResult = FilesModel::uploadFile(
                $postFile,
                SiteMediaModel::getFolderPath($folder, SiteMediaModel::ORIG_PATH),
                null,
                SiteMediaModel::getFolderExtensions($folder)
            );

            include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");
            $editor = new AdminEditModel(array(
                'table' => 'site_media_files',
                'id' => null
            ));

            $file = $editor->loadRecord();
            $file->folder_id = $folder->id;
            $file->name_orig = $uploadResult['name_orig'];
            $file->name_new = $uploadResult['name_new'];
            $file->size = $uploadResult['size'];
            $file->extension = $uploadResult['extension'];
            $file->mime_type = $uploadResult['mime_type'];

            if (FilesModel::isImageFile($uploadResult['name_orig'])) {
                SiteMediaModel::generateImageSizes(
                    $file, SiteMediaModel::getFolderImageSizes($folder)
                );
            }

            if ($editor->saveRecord()) {
                SiteMediaModel::saveCacheData(
                    SiteMediaModel::getCacheFilename($file->id),
                    SiteMediaModel::getFileData($file)
                );
                return $file;
            } else {
                throw new Exception('Error saving to DB.');
            }

        } else {
            throw new Exception('File is missing.');
        }
    }//uploadFile

    static function copyFile($src, $folder)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

        $newName = FilesModel::copyFile(
            SiteMediaModel::getFilePath($src, SiteMediaModel::ORIG_PATH),
            SiteMediaModel::getFolderPath($folder, SiteMediaModel::ORIG_PATH),
            null,
            SiteMediaModel::getFolderExtensions($folder)
        );

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");
        $editor = new AdminEditModel(array(
            'table' => 'site_media_files',
            'id' => null
        ));

        $file = $editor->loadRecord();
        $file->folder_id = $folder->id;
        $file->name_orig = $src->name_orig;
        $file->name_new = $newName;
        $file->size = $src->size;
        $file->extension = $src->extension;
        $file->mime_type = $src->mime_type;

        if (FilesModel::isImageFile($file->name_orig)) {
            SiteMediaModel::generateImageSizes(
                $file, SiteMediaModel::getFolderImageSizes($folder)
            );
        }

        if ($editor->saveRecord()) {
            SiteMediaModel::saveCacheData(
                SiteMediaModel::getCacheFilename($file->id),
                SiteMediaModel::getFileData($file)
            );
            return $file;
        } else {
            throw new Exception('Error saving to DB.');
        }

    }//copyFile

    static function generateImageSizes($file, $sizes)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/images_model.php");
        foreach ($sizes as $sizeOptions) {
            $res = ImagesModel::copyResized(
                SiteMediaModel::getFilePath($file),
                SiteMediaModel::getFilePath($file, $sizeOptions->label),
                $sizeOptions
            );
        }
    }

    static function cropImage($folder, $file, $cropSizeId, $srcCoords, $srcSize)
    {
        $cropSizes = SiteMediaModel::getFolderCropSizes($folder);
        if (!$cropSizes || !array_key_exists($cropSizeId, $cropSizes)) throw new Exception('Invalid size value.');

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/images_model.php");
        foreach ($cropSizes[$cropSizeId]->sizes as $size) {
            ImagesModel::copyCropped(
                SiteMediaModel::getFilePath($file),
                SiteMediaModel::getFilePath($file, $size->label),
                $srcCoords,
                $srcSize,
                array('width' => $size->width, 'height' => $size->height)
            );
        }

        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_edit_model.php");
        $editor = new AdminEditModel(array('table' => 'site_media_files', 'id' => $file->id));
        $record = $editor->loadRecord();
        if ($editor->saveRecord()) {
            SiteMediaModel::saveCacheData(
                SiteMediaModel::getCacheFilename($record->id),
                SiteMediaModel::getFileData($record)
            );
        } else {
            throw new Exception('Error saving to DB.');
        }

    }//cropImage

    static function getFileUrl($folder, $filename, $size = null)
    {
        if ($filename && $folder) {

            if (!is_numeric($folder)) {
                $id = $folder;
                $folder = null;
                static $folders = null;
                if (!isset($folders)) $folders = SiteMediaModel::getFolders();
                if ($folders) foreach ($folders as $f) {
                    if ($f->label == $id) {
                        $folder = $f->id;
                        break;
                    }
                }
                if (!$folder) return null;
            }

            return "/media/" . $folder . "/" . ($size ? $size : SiteMediaModel::ORIG_PATH) . "/" . $filename;
        }

        return null;
    }//getFileUrl

    static function isFileExists($folder, $filename, $size = null)
    {
        $url = SiteMediaModel::getFileUrl($folder, $filename, $size);
        return $url && file_exists($_SERVER["DOCUMENT_ROOT"] . str_replace("/", DIRECTORY_SEPARATOR, $url));
    }//isFileExists

    static function getSvg($id)
    {
        $svg = "";
        if ($file = SiteMediaModel::getFile($id)) {
            $path = SiteMediaModel::getFilePath($file);
            if (file_exists($path)) {
                if ($svg = @file_get_contents($path)) {
                    $dom = new DOMDocument();
                    $dom->loadXML($svg);
                    $items = $dom->getElementsByTagName("svg");
                    if ($items->length) {
                        $doc = new DOMDocument();
                        $doc->appendChild($doc->importNode($items->item(0), true));
                        $svg = $doc->saveHTML();
                    }
                }
            }
        }
        return $svg;
    }

    static function getCacheFilename($id)
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/media/_cache/" . implode("/", str_split(str_pad($id, 10, "0", STR_PAD_LEFT), 2));
    }

    static function getFileData($file)
    {
        return array(
            $file->folder_id,
            $file->name_new,
            isset($file->datetime_update) && $file->datetime_update ? strtotime($file->datetime_update) : ''
        );
    }

    static function getCacheData($filename)
    {
        $cache = file_get_contents($filename);
        return $cache ? explode(",", $cache) : null;
    }

    static function saveCacheData($filename, $data)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");
        FilesModel::prepareDirectory(dirname($filename));
        file_put_contents($filename, $data ? implode(",", $data) : "");
        @chmod($cache, 0777);
    }

}

?>
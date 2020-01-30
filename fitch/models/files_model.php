<?php

ini_set("display_errors", 0);
error_reporting(0);

class FilesModel
{

    static $extensions_images = array("gif", "jpg", "jpeg", "png");

    static function getPostFile($fieldName)
    {
        if (is_array($fieldName)) {
            $file = array('name' => null, 'type' => null, 'tmp_name' => null, 'error' => null, 'size' => null);
            foreach ($file as $parameter => $val) {
                $val = $_FILES;
                foreach (array_merge(array($fieldName[0], $parameter), array_slice($fieldName, 1)) as $key) {
                    $val = is_array($val) && array_key_exists($key, $val) ? $val[$key] : null;
                }
                $file[$parameter] = $val;
            }
            return $file;
        } else return isset($_FILES[$fieldName]) ? $_FILES[$fieldName] : null;
    }//getPostFile

    private static function parseSize($size)
    {
        $size = trim($size);
        switch (strtolower($size{strlen($size) - 1})) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }
        return (int)$size;
    }//parseSize

    private static function getIniMaxFilesize()
    {
        return FilesModel::parseSize(ini_get('upload_max_filesize'));
    }//getIniMaxFilesize

    private static function getFormMaxFilesize()
    {
        return isset($_POST['MAX_FILE_SIZE']) ? FilesModel::parseSize($_POST['MAX_FILE_SIZE']) : null;
    }//getFormMaxFilesize

    static function computeMaxFilesize($limit = null)
    {
        $sizes = array();
        if ($limit) {
            if ($size = FilesModel::parseSize($limit)) $sizes[] = $size;
        }
        if ($size = FilesModel::getIniMaxFilesize()) $sizes[] = $size;
        if ($size = FilesModel::getFormMaxFilesize()) $sizes[] = $size;
        return min($sizes);
    }//computeMaxFilesize

    static function prepareDirectory($dirname)
    {
        if (file_exists($dirname)) return true;
        if (FilesModel::prepareDirectory(dirname($dirname))) return mkdir($dirname, 0777);
        throw new Exception('Can\'t create specific directory.');
    }//prepareDirectory

    static function removeDirectory($dirname)
    {
        if (file_exists($dirname)) {
            $dir = new RecursiveDirectoryIterator($dirname);
            $files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                if ($filename === '.' || $filename === '..') continue;
                if ($file->isDir()) @rmdir($file->getRealPath());
                else @unlink($file->getRealPath());
            }
            @rmdir($dirname);
        }
    }//removeDirectory

    static function removeFile($filename)
    {
        if (file_exists($filename)) @unlink($filename);
    }//removeFile

    static function getFileExtension($f)
    {
        return strtolower(pathinfo($f, PATHINFO_EXTENSION));
    }//getFileExtension

    static function isImageFile($file)
    {
        return in_array(FilesModel::getFileExtension($file), FilesModel::$extensions_images);
    }//isImageFile

    static function uploadFile($postFile, $location, $nameNew = null, $extensions = null, $maxFileSize = null)
    {
        $maxFileSize = FilesModel::computeMaxFilesize($maxFileSize);

        switch ($postFile['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('The uploaded file exceeds the ' . $maxFileSize . ' bytes.');
                break;
            case UPLOAD_ERR_PARTIAL:
                throw new Exception('The uploaded file was only partially uploaded.');
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file was uploaded.');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new Exception('Missing a temporary folder.');
                break;
            case UPLOAD_ERR_CANT_WRITE:
                throw new Exception('Failed to write file to disk.');
                break;
            case UPLOAD_ERR_EXTENSION:
                throw new Exception('A PHP extension stopped the file upload.');
                break;
        }

        $result = array(
            'size' => (int)$postFile['size'],
            'name_orig' => isset($postFile['name']) ? $postFile['name'] : '',
            'mime_type' => $postFile['type']
        );

        $tempName = isset($postFile['tmp_name']) ? $postFile['tmp_name'] : '';

        if ($result['size'] > $maxFileSize) {
            throw new Exception('The uploaded file exceeds the ' . $maxFileSize . ' bytes.');
        }

        $result['extension'] = FilesModel::getFileExtension($result['name_orig']);

        if (is_array($extensions)) {
            $extensions = array_map("strtolower", $extensions);
            if (!in_array($result['extension'], $extensions)) {
                throw new Exception('Forbidden file type. Allowed extensions are: ' . implode(', ', $extensions) . '.');
            }
        }

        if (!is_uploaded_file($tempName)) throw new Exception('Invalid file.');

        $result['name_new'] = ($nameNew ? $nameNew : time() . '-' . str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT)) . "." . $result['extension'];
        $destination = $location . DIR_SEP . $result['name_new'];

        FilesModel::prepareDirectory(dirname($destination));

        if (!@move_uploaded_file($tempName, $destination)) {
            throw new Exception('Can\'t move uploaded file to specific location.');
        }

        // checking if it's JPG file and if EXIF auto-rotation is needed
        if (isset($result['mime_type']) && $result['mime_type'] == "image/jpeg") {
            FilesModel::adjustImageOrientation($destination);
        }

        @chmod($destination, 0777);

        return $result;
    }//uploadFile

    static function copyFile($file, $location, $nameNew = null, $extensions = null, $maxFileSize = null)
    {
        $maxFileSize = FilesModel::computeMaxFilesize($maxFileSize);

        if (filesize($file) > $maxFileSize) {
            throw new Exception('The uploaded file exceeds the ' . $maxFileSize . ' bytes.');
        }

        $extension = FilesModel::getFileExtension(basename($file));

        if (is_array($extensions)) {
            $extensions = array_map("strtolower", $extensions);
            if (!in_array($extension, $extensions)) {
                throw new Exception('Forbidden file type. Allowed extensions are: ' . implode(', ', $extensions) . '.');
            }
        }

        $result = ($nameNew ? $nameNew : time() . '-' . str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT)) . "." . $extension;
        $destination = $location . DIR_SEP . $result;

        FilesModel::prepareDirectory(dirname($destination));

        if (!@copy($file, $destination)) {
            throw new Exception('Can\'t copy file to specific location.');
        }

        @chmod($destination, 0777);

        return $result;
    }//copyFile

    static function mirrorImage($imgsrc)
    {
        $width = imagesx($imgsrc);
        $height = imagesy($imgsrc);

        $src_x = $width - 1;
        $src_y = 0;
        $src_width = -$width;
        $src_height = $height;

        $imgdest = imagecreatetruecolor($width, $height);

        if (imagecopyresampled($imgdest, $imgsrc, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height)) {
            return $imgdest;
        }

        return $imgsrc;
    }//mirrorImage

    static function adjustImageOrientation($imageFile)
    {
        if (!function_exists('exif_read_data')) return true;
        $exif = @exif_read_data($imageFile);
        if ($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if ($orientation != 1) {
                try {
                    $img = imagecreatefromjpeg($imageFile);

                    $mirror = false;
                    $deg = 0;

                    switch ($orientation) {
                        case 2:
                            $mirror = true;
                            break;
                        case 3:
                            $deg = 180;
                            break;
                        case 4:
                            $deg = 180;
                            $mirror = true;
                            break;
                        case 5:
                            $deg = 270;
                            $mirror = true;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 7:
                            $deg = 90;
                            $mirror = true;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }


                    if ($deg) $img = imagerotate($img, $deg, 0);
                    if ($mirror) $img = FilesModel::mirrorImage($img);
                    imagejpeg($img, $imageFile, 100);
                    imagedestroy($img);

                } catch (Exception $e) {
                    throw new Exception("Error: " . $e->getMessage());
                }
            }
        }
        return true;
    }//adjustImageOrientation

}

?>
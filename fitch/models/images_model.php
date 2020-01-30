<?php

class ImagesModel
{

    static function copyResized($srcFile, $dstFile, $options)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

        FilesModel::prepareDirectory(dirname($dstFile));

        $gifTransparency = false;
        $pngTransparency = false;

        switch (FilesModel::getFileExtension($srcFile)) {
            case "gif":
                $srcImg = @imagecreatefromgif($srcFile);
                $gifTransparency = true;
                break;
            case "jpeg":
            case "jpg":
                $srcImg = @imagecreatefromjpeg($srcFile);
                break;
            default:
                $srcImg = @imagecreatefrompng($srcFile);
                $pngTransparency = true;
        }

        if (!$srcImg) throw new Exception('Fail obtaining image from the file.');

        if ($gifTransparency) {
            $gifTransparency = imagecolortransparent($srcImg);
            if ($gifTransparency < 0) $gifTransparency = false;
        } elseif ($pngTransparency) {
            imagealphablending($srcImg, true);
        }

        if (is_object($options)) $options = get_object_vars($options);
        $options = array_merge(array(
            'width' => 100,
            'height' => 100,
            'save_aspect_ratio' => false,
            'enlarge_small_images' => false,
            'fit_small_images' => false,
            'fit_large_images' => false,
            'background_color' => false
        ), $options);

        if ($options['background_color']) {
            if (preg_match("/^#([\da-f])([\da-f])([\da-f])$/i", $options['background_color'], $m)) {
                $options['background_color'] = array(hexdec($m[1] . $m[1]), hexdec($m[2] . $m[2]), hexdec($m[3] . $m[3]));
            } elseif (preg_match("/^#([\da-f]{2})([\da-f]{2})([\da-f]{2})$/i", $options['background_color'], $m)) {
                $options['background_color'] = array(hexdec($m[1]), hexdec($m[2]), hexdec($m[3]));
            } else {
                $options['background_color'] = null;
            }
        }
        if (!$options['background_color']) $options['background_color'] = array(0xFF, 0xFF, 0xFF);

        $srcWidth = imagesx($srcImg);
        $srcHeight = imagesy($srcImg);

        $isSmaller = $srcWidth < $options['width'] && $srcHeight < $options['height'];
        $isLarger = $srcWidth > $options['width'] && $srcHeight > $options['height'];

        if ($options['width'] == $srcWidth && $options['height'] == $srcHeight
            || ($options['save_aspect_ratio'] && $isSmaller && !$options['enlarge_small_images'])) {
            copy($srcFile, $dstFile);
        } else {

            $setBg = false;
            $resizeMode = null;

            if ($options['save_aspect_ratio']) $resizeMode = 'fit';
            elseif ($isSmaller) {
                if ($options['enlarge_small_images']) {
                    if ($options['fit_small_images']) {
                        $resizeMode = 'fit';
                        $setBg = true;
                    } else $resizeMode = 'fill';
                } else $setBg = true;
            } elseif ($isLarger) {
                if ($options['fit_large_images']) {
                    $resizeMode = 'fit';
                    $setBg = true;
                } else $resizeMode = 'fill';
            } else {
                if ($options['fit_large_images']) {
                    $resizeMode = 'fit';
                    $setBg = true;
                } elseif ($options['enlarge_small_images']) $resizeMode = 'fill';
                else $setBg = true;
            }

            $resizedWidth = $srcWidth;
            $resizedHeight = $srcHeight;

            if ($resizeMode) {
                $ratio = $srcWidth / $srcHeight;
                $cond = $options['width'] / $options['height'] < $ratio;
                if ($resizeMode == 'fill') $cond = !$cond;
                if ($cond) {
                    $resizedWidth = $options['width'];
                    $resizedHeight = $resizedWidth / $ratio;
                } else {
                    $resizedHeight = $options['height'];
                    $resizedWidth = $resizedHeight * $ratio;
                }
            }

            $dstWidth = $options['save_aspect_ratio'] ? $resizedWidth : $options['width'];
            $dstHeight = $options['save_aspect_ratio'] ? $resizedHeight : $options['height'];

            $dstImg = imagecreatetruecolor($dstWidth, $dstHeight);

            if ($setBg) {
                imagefill(
                    $dstImg, 0, 0,
                    imagecolorallocate(
                        $dstImg,
                        $options['background_color'][0],
                        $options['background_color'][1],
                        $options['background_color'][2]
                    )
                );
            } elseif ($gifTransparency) {
                imagepalettecopy($srcImg, $dstImg);
                imagefill($dstImg, 0, 0, $gifTransparency);
                imagecolortransparent($dstImg, $gifTransparency);
                imagetruecolortopalette($dstImg, true, 256);
            } elseif ($pngTransparency) {
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);
                imagefill(
                    $dstImg, 0, 0,
                    imagecolorallocatealpha($dstImg, 255, 255, 255, 127)
                );
            }

            imagecopyresampled(
                $dstImg, $srcImg,
                round(($dstWidth - $resizedWidth) / 2),
                round(($dstHeight - $resizedHeight) / 2),
                0, 0,
                round($resizedWidth),
                round($resizedHeight),
                round($srcWidth),
                round($srcHeight)
            );

            switch (FilesModel::getFileExtension($dstFile)) {
                case "gif":
                    $result = @imagegif($dstImg, $dstFile);
                    break;
                case "jpeg":
                case "jpg":
                    $result = @imagejpeg($dstImg, $dstFile, 100);
                    break;
                default:
                    $result = @imagepng($dstImg, $dstFile);
            }

            if (!$result) throw new Exception("Fail saving resized image.");

        }

        @chmod($dstFile, 0777);
        if (isset($srcImg)) @imagedestroy($srcImg);
        if (isset($dstImg)) @imagedestroy($dstImg);

        return true;
    }//copyResized


    static function copyCropped($srcFile, $dstFile, $coords, $srcSize, $dstSize)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/files_model.php");

        FilesModel::prepareDirectory(dirname($dstFile));

        $gifTransparency = false;
        $pngTransparency = false;

        switch (FilesModel::getFileExtension($srcFile)) {
            case "gif":
                $srcImg = @imagecreatefromgif($srcFile);
                $gifTransparency = true;
                break;
            case "jpeg":
            case "jpg":
                $srcImg = @imagecreatefromjpeg($srcFile);
                break;
            default:
                $srcImg = @imagecreatefrompng($srcFile);
                $pngTransparency = true;
        }

        if (!$srcImg) throw new Exception('Fail obtaining image from the file.');

        if ($gifTransparency) {
            $gifTransparency = imagecolortransparent($srcImg);
            if ($gifTransparency < 0) $gifTransparency = false;
        } elseif ($pngTransparency) {
            imagealphablending($srcImg, true);
        }

        $dstImg = imagecreatetruecolor($dstSize['width'], $dstSize['height']);

        if ($gifTransparency) {
            imagepalettecopy($srcImg, $dstImg);
            imagefill($dstImg, 0, 0, $gifTransparency);
            imagecolortransparent($dstImg, $gifTransparency);
            imagetruecolortopalette($dstImg, true, 256);
        } elseif ($pngTransparency) {
            imagealphablending($dstImg, false);
            imagesavealpha($dstImg, true);
            imagefill(
                $dstImg, 0, 0,
                imagecolorallocatealpha($dstImg, 255, 255, 255, 127)
            );
        }

        imagecopyresampled(
            $dstImg, $srcImg,
            0, 0,
            (int)$coords['x'], (int)$coords['y'],
            (int)$dstSize['width'], (int)$dstSize['height'],
            (int)$srcSize['width'], (int)$srcSize['height']
        );

        switch (FilesModel::getFileExtension($dstFile)) {
            case "gif":
                $result = @imagegif($dstImg, $dstFile);
                break;
            case "jpeg":
            case "jpg":
                $result = @imagejpeg($dstImg, $dstFile, 100);
                break;
            default:
                $result = @imagepng($dstImg, $dstFile);
        }

        if (!$result) throw new Exception("Fail saving resized image.");

        @chmod($dstFile, 0777);
        if (isset($srcImg)) @imagedestroy($srcImg);
        if (isset($dstImg)) @imagedestroy($dstImg);

        return true;
    }//copyCropped

}

?>
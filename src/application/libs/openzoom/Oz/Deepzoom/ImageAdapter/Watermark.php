<?php

namespace Deepzoom\ImageAdapter;

class Watermark {

    public static function insertWatermark(&$img, $width, $height, $mode) {
        $watermarkFile = \__Config::get('IMG_WATERMARK');
        $watermarkFile = $watermarkFile ? \__Paths::getRealPath('BASE', $watermarkFile) : false;
        if(!$watermarkFile || ($width < 100 && $height < 100)) {
            return;
        }
        $perc = \__Config::get('IMG_WATERMARK_SIZE_PERC');
        if($mode == 'Imagick') {
            $watermark = new Imagick();
            $watermark->readImage($watermarkFile);
            $w_height = $watermark->getImageHeight();
            $w_width = $watermark->getImageWidth();
        } else {
            $watermark = imagecreatefrompng($watermarkFile);
            imagealphablending($watermark, true);
            $w_width = imagesx($watermark);
            $w_height = imagesy($watermark);
        };
        if($width > $height) {
            $sy = $height*$perc/100;
            $sx = $w_width/$w_height*$sy;
        } else {
            $sx = $width*$perc/100;
            $sy = $sx*$w_height/$w_width;
        }
        $posx = ($width -$sx)/2;
        $posy = ($height - $sy)/2;
        if($mode == 'Imagick') {
            $watermark->scaleImage($sx, $sy);
            $img->compositeImage($watermark, imagick::COMPOSITE_OVER, $posx, $posy);
            $watermark->clear();
            $watermark->destroy();
        } else {
            imagecopyresampled($img, $watermark, $posx, $posy, 0, 0, $sx, $sy, imagesx($watermark), imagesy($watermark));
            imagedestroy($watermark);
        }
    }
}
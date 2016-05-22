<?php

namespace Deepzoom\ImageAdapter;
use Deepzoom\ImageAdapter\Watermark;

class ImagickWatermark extends Imagick {

    private $watermarkPath;
    private $watermark;

    public function __construct ($watermark, $watermarkPath = null)
    {
        parent::__construct();
        $this->watermark = $watermark;
        $this->watermarkPath = $watermarkPath;
    }

     public function save($destination, $format=null) {
        if($this->watermark) {
            $imgDim = $this->getDimensions();
            Watermark::insertWatermark($this, $imgDim['width'], $imgDim['height'], 'Imagick');
        }
        return parent::save($destination, $format);
     }
}
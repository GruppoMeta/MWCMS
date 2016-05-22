<?php

namespace Deepzoom\ImageAdapter;
use Deepzoom\ImageAdapter\Watermark;

class GdThumbWatermark extends GdThumb {

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
            Watermark::insertWatermark($this->workingImage, $imgDim['width'], $imgDim['height'], 'Gd');
        }
        return parent::save($destination, $format);
     }
}
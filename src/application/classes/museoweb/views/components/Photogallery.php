<?php
class museoweb_views_components_Photogallery extends org_glizy_components_Groupbox
{
    private $galleryType;

    function process() {
        $this->galleryType = $this->loadContent('galleryType');
        if (!$this->galleryType) {
            $this->galleryType = 'gallery';
        }
        parent::process();
    }

    function getContent() {
        $imageCrop = $this->loadContent('imageCrop');
        $imagePan = $this->loadContent('imagePan');
        $imagePosition = $imageCrop == 1 && $imagePan == 1 ? 'top right' : '50%';
        $content = parent::getContent();
        return array(   'images' => $content['images'],
                        'imageCrop' => $imageCrop == 1 ? 'true' : 'false',
                        'imagePan' => $imagePan == 1 ? 'true' : 'false',
                        'imagePosition' => $imagePosition,
                        'type' => $this->galleryType
                    );
    }

    function render($mode) {
        if (!$this->_application->isAdmin()) {
            $this->setAttribute('skin', 'Photogallery.html');
        }
        parent::render($mode);
    }
}

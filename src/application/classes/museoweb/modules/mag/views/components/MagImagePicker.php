<?php
class museoweb_modules_mag_views_components_MagImagePicker extends org_glizy_components_Input
{
    function init()
    {
        // define the custom attributes
        $this->defineAttribute('ajaxController', false, 'museoweb.modules.mag.controllers.ajax.MagImagePicker', COMPONENT_TYPE_STRING);

        parent::init();
        $this->setAttribute('data', ';type=MwcmsImagePicker;controllername='.$this->getAttribute('ajaxController'), true);
    }
}

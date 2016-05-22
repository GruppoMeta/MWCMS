<?php
class museoweb_modules_mag_controllers_ajax_MagImagePicker extends org_glizy_mvc_core_CommandAjax
{

    public function execute($id)
    {
        $data = array();
        if($id)
        {
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            return $magProxy->getImageInfoById($id);
        }
        return false;
    }
}
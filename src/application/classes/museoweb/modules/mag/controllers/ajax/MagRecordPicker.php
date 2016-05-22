<?php
class museoweb_modules_mag_controllers_ajax_MagRecordPicker extends org_glizy_mvc_core_CommandAjax
{
    function execute($type, $term, $id)
    {
        $this->directOutput = true;
        $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
        if (!$id) {
            return $magProxy->searchForAutocomplete($type, $term);
        } else {
            return $magProxy->getRecordInfoById($id);
        }
    }
}
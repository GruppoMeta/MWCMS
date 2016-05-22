<?php
class museoweb_massiveImporter_controllers_ajax_LoadMapping extends org_glizy_mvc_core_CommandAjax
{
    public function execute($mappingId)
    {
        if ($mappingId) {
            $ar = org_glizy_ObjectFactory::createModel('museoweb.massiveImporter.models.Mapping');
            $ar->load($mappingId);

            $this->directOutput = true;
            return unserialize($ar->massiveimporter_mapping_mapping);
        }
    }
}
<?php
class museoweb_modules_solr_controllers_ajax_GetMapping extends org_glizy_mvc_core_CommandAjax
{
    CONST REGISTRY_SOLR_MAP = '/solr/mapping';

    public function execute($id)
    {
        $dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
        $defaultMapping = $dcProxy->getDefaultMappingById($id);
        $map = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/'.$id, '')) ?: unserialize($defaultMapping);
        return $map;
    }
}

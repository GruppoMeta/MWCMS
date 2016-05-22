<?php
class museoweb_modules_solr_controllers_ajax_DcList extends org_glizy_mvc_core_CommandAjax
{
    CONST REGISTRY_SOLR_PROFILE = '/solr/profile';

    public function execute()
    {
        $dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
        $defaultProfile = $dcProxy->getDefaultProfile();
        return unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_PROFILE, '')) ?: unserialize($defaultProfile);
    }
}
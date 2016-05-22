<?php
class museoweb_modules_solr_controllers_ajax_ModuleDelete extends org_glizy_mvc_core_CommandAjax
{
    CONST REGISTRY_SOLR_MAP = '/solr/mapping';

    public function execute($id)
    {
        org_glizy_Registry::remove(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/'.$id);
        $active = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/activeModules', '')) ?: array();
        if(array_key_exists ( $id, $active ) ) {
           unset($active[$id]);
           org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/activeModules', serialize($active));
        }
        return true;
    }
}
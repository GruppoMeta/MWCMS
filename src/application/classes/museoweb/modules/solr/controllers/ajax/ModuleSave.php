<?php
class museoweb_modules_solr_controllers_ajax_ModuleSave extends org_glizy_mvc_core_CommandAjax
{
    CONST REGISTRY_SOLR_MAP = '/solr/mapping';

    public function execute($data)
    {
        $data = json_decode($data);
        $data = $data->moduleEditTab;
        org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/'.$data->moduleId, serialize($data->mapping));
        $active = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/activeModules', '')) ?: array();
        if(!array_key_exists ( $data->moduleId, $active ) ) {
           $active[$data->moduleId] = false;
           org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/activeModules', serialize($active));
        }
        return true;
    }
}
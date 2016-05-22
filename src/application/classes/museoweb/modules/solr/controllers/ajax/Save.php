<?php
class museoweb_modules_solr_controllers_ajax_Save extends org_glizy_mvc_core_CommandAjax
{

    CONST REGISTRY_SOLR_MAP_ACTIVE = '/solr/mapping/activeModules';
    CONST REGISTRY_SOLR_ENABLED = '/solr/enabled';

    public function execute($data)
    {
        $data = json_decode($data);
        $solrEnabled = $data->solrEnabled == 1 ? 'true' : 'false';
        unset ($data->solrEnabled);
        $modules = array();
        foreach ($data as $key => $checkModule) {
            if($checkModule === 0 || $checkModule ===1) {
                $modules[$key] = $checkModule ? true : false;
            }
        }
        $modules = serialize($modules);
        org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_ENABLED, $solrEnabled);
        org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP_ACTIVE, $modules);

        return true;
    }
}
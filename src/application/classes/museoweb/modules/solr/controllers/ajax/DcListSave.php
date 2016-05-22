<?php
class museoweb_modules_solr_controllers_ajax_DcListSave extends org_glizy_mvc_core_CommandAjax
{
    CONST REGISTRY_SOLR_PROFILE = '/solr/profile';

    public function execute($data)
    {
        $data = json_decode($data);
        $data = serialize(json_decode($data->dcListTab));
        org_glizy_Registry::set(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_PROFILE, $data);
        return true;
    }
}
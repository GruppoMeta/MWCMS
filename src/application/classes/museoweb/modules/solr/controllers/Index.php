<?php
class museoweb_modules_solr_controllers_Index extends org_glizy_mvc_core_Command
{
    CONST REGISTRY_SOLR_ENABLED = '/solr/enabled';
    CONST REGISTRY_SOLR_MAP_ACTIVE = '/solr/mapping/activeModules';

    public function execute($data)
    {
        $data = new StdClass;
        $data->solrEnabled = org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_ENABLED) == "true" ? 1 : 0;
        $modules = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP_ACTIVE, ''));

        if (!is_array($modules)) {
            $modules = array();
        }

        foreach ($modules as $k => $v) {
            $data->{$k} = $v ? 1 : 0;
        }
        if (method_exists($this->view, 'setData')) {
            $this->view->setData($data);
        }
    }
}
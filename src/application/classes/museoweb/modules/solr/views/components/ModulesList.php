<?php
class museoweb_modules_solr_views_components_ModulesList extends org_glizy_components_Input
{
    CONST REGISTRY_SOLR_MAP = '/solr/mapping';

    function process()
    {
        $modules = org_glizy_Modules::getModulesSorted();
        $params = array();
        $active = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP.'/activeModules', '')) ?: array();
        foreach ($modules as $module) {
            if ($this->_user->acl($module->id, 'all') && $module->model) {
                $params[$module->id] = $module->name;
            }
        }
        $this->setAttribute('type', 'hidden');
        $this->setAttribute('data', ';type=mwcmsModulesList;modules='.json_encode($params).';active_modules='.json_encode($active).';controllername='.$this->getAttribute('ajaxController'), true);
    }

}

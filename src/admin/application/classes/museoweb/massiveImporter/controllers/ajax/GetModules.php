<?php
class museoweb_massiveImporter_controllers_ajax_GetModules extends org_glizy_mvc_core_CommandAjax
{
    public function execute()
    {
        $modules = org_glizy_Modules::getModules();

        $result = array();

        foreach ($modules as $module) {
            if (!$this->user->acl($module->id, 'all') || !$module->model) {
                continue;
            }
            $result[] = array(
                'id' => $module->id,
                'value' => $module->name
            );
        }

        org_glizy_helpers_Array::arrayMultisortByLabel($result, 'value');
        return $result;
    }
}
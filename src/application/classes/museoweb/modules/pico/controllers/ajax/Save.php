<?php
class museoweb_modules_pico_controllers_ajax_Save extends org_glizy_mvc_core_CommandAjax
{
    public function execute($data)
    {
        $this->directOutput = true;
        $data = json_decode($data);
        $newData = array();
        $newData['title'] = $data->title;
        $newData['email'] = $data->email;
        $newData['identify'] = $data->identify;
        $newData['modules'] = array();

        $availableModules = museoweb_modules_pico_Module::getMappingToModel();
        foreach ($availableModules as $k=>$v) {
            if (property_exists($data, $k) && $data->{$k}===1) {
                $newData['modules'][$k] = $v;
            }
        }

        org_glizy_Registry::set( museoweb_modules_pico_Module::getRegistryPath(), serialize($newData));
        return array('callback' => 'mwcms_startAjaxSteps');
    }
}
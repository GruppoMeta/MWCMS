<?php
class museoweb_modules_pico_controllers_Index extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $values = unserialize(org_glizy_Registry::get(museoweb_modules_pico_Module::getRegistryPath(), ''));
        if ($values) {
            if (isset($values['modules'])) {
                foreach ($values['modules'] as $k=>$v) {
                    $values[$k] = 1;
                }
            }

            $this->view->getComponentById('myForm')->setData($values);
        }
    }
}
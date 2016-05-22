<?php
class museoweb_modules_pico_controllers_ajax_DeleteIndex extends org_glizy_mvc_core_CommandAjax
{
    function execute($mapping)
    {
        if ($this->user->isLogged())
        {
            $availableModules = museoweb_modules_pico_Module::getMappingToModel();
            if (isset($availableModules[$mapping])) {
                $evt = array('type' => museoweb_modules_pico_Module::EVT_DELETE_MODEL.'@'.$availableModules[$mapping], 'data' => $mapping);
                $this->dispatchEvent($evt);
            }
        }

        return true;
    }
}

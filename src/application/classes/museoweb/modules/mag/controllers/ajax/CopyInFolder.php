<?php
class museoweb_modules_mag_controllers_ajax_CopyInFolder extends org_glizy_mvc_core_CommandAjax
{
    function execute($moduleName)
    {
        if ($this->user->isLogged())
        {
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            $exportFolder = $magProxy->getExportFolder();
            $destFolder = __Config::get('mwcms.mag.magFolder').$moduleName;
            org_glizy_helpers_Files::copyDirectory($exportFolder, $destFolder);
            return true;
        }
    }
}
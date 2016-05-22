<?php
class museoweb_modules_iccd_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.iccd';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_iccd';
        $moduleVO->name = 'Generatore schede ICCD';
        $moduleVO->description = 'Modulo creazione schede iccd';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = '';
        $moduleVO->siteMapAdmin = '<glz:Page parentId="glizycms_system" pageType="museoweb.modules.iccd.views.Admin" id="museoweb_modules_iccd" value="{i18n:'.$moduleVO->name.'}" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}
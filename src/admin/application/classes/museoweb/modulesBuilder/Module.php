<?php
class museoweb_modulesBuilder_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modulesBuilder';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modulesBuilder';
        $moduleVO->name = 'Module Builder';
        $moduleVO->description = 'Modulo per la creazione di moduli';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = '';
        $moduleVO->siteMapAdmin = '<glz:Page parentId="glizycms_system" pageType="museoweb.modulesBuilder.views.Admin" id="museoweb_modulesBuilder" value="{i18n:'.$moduleVO->name.'}" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}
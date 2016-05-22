<?php
class museoweb_modules_mag_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.mag';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_mag';
        $moduleVO->name = __T('museoweb.modules.mag.views.FrontEnd');
        $moduleVO->description = 'Modulo di catalogazione Scheda MAG';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->pageType = '';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.mag.views.Admin" id="museoweb_modules_mag" value="{i18n:museoweb.modules.mag.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

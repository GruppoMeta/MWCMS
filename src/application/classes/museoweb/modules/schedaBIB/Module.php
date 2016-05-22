<?php
class museoweb_modules_schedaBIB_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.schedaBIB';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_schedaBIB';
        $moduleVO->name = __T('museoweb.modules.schedaBIB.views.FrontEnd');
        $moduleVO->description = 'Modulo di catalogazione Scheda BIB';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->pageType = 'museoweb.modules.schedaBIB.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.schedaBIB.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.schedaBIB.views.Admin" id="museoweb_modules_schedaBIB" value="{i18n:museoweb.modules.schedaBIB.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->siteMapAdmin .= '<glz:Page pageType="museoweb.modules.schedaBIB.views.AdminPopup" id="museoweb_modules_schedaBIB_popup"/>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

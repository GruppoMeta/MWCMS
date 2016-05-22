<?php
class museoweb_modules_schedaAUT_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.schedaAUT';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_schedaAUT';
        $moduleVO->name = __T('museoweb.modules.schedaAUT.views.FrontEnd');
        $moduleVO->description = 'Modulo di catalogazione Scheda AUT';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->pageType = 'museoweb.modules.schedaAUT.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.schedaAUT.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.schedaAUT.views.Admin" id="museoweb_modules_schedaAUT" value="{i18n:museoweb.modules.schedaAUT.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->siteMapAdmin .= '<glz:Page pageType="museoweb.modules.schedaAUT.views.AdminPopup" id="museoweb_modules_schedaAUT_popup"/>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

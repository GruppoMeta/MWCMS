<?php
class museoweb_modules_schedaRCG_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.schedaRCG';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_schedaRCG';
        $moduleVO->name = __T('museoweb.modules.schedaRCG.views.FrontEnd');
        $moduleVO->description = 'Modulo di catalogazione Scheda RCG';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->pageType = 'museoweb.modules.schedaRCG.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.schedaRCG.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.schedaRCG.views.Admin" id="museoweb_modules_schedaRCG" value="{i18n:museoweb.modules.schedaRCG.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->siteMapAdmin .= '<glz:Page pageType="museoweb.modules.schedaRCG.views.AdminPopup" id="museoweb_modules_schedaRCG_popup"/>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

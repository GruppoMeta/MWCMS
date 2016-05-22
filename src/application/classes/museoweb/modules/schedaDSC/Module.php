<?php
class museoweb_modules_schedaDSC_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.schedaDSC';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_schedaDSC';
        $moduleVO->name = __T('museoweb.modules.schedaDSC.views.FrontEnd');
        $moduleVO->description = 'Modulo di catalogazione Scheda DSC';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->pageType = 'museoweb.modules.schedaDSC.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.schedaDSC.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.schedaDSC.views.Admin" id="museoweb_modules_schedaDSC" value="{i18n:museoweb.modules.schedaDSC.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->siteMapAdmin .= '<glz:Page pageType="museoweb.modules.schedaDSC.views.AdminPopup" id="museoweb_modules_schedaDSC_popup"/>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

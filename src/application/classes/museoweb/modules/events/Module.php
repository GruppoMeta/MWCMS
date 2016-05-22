<?php
class museoweb_modules_events_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Events';
        $moduleVO->name = __T('museoweb.modules.events.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione degli eventi';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.events';
        $moduleVO->pageType = 'museoweb.modules.events.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.events.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.events.views.Admin" id="museoweb_Events" value="{i18n:museoweb.modules.events.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        org_glizy_Modules::addModule( $moduleVO );
    }
}

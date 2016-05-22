<?php
class museoweb_modules_merchandising_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Merchandising';
        $moduleVO->name = __T('museoweb.modules.merchandising.views.FrontEnd');
        $moduleVO->description = 'Modulo di gestione del merchandising';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.merchandising';
        $moduleVO->pageType = 'museoweb.modules.merchandising.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.merchandising.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.merchandising.views.Admin" id="museoweb_Merchandising" value="{i18n:Merchandising}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

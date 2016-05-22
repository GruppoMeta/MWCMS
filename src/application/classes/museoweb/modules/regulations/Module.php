<?php
class museoweb_modules_regulations_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_regulations';
        $moduleVO->name = __T('museoweb.modules.regulations.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione delle normative';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.regulations';
        $moduleVO->pageType = 'museoweb.modules.regulations.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.regulations.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.regulations.views.Admin" id="museoweb_regulations" value="{i18n:Normative}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );
    }
}
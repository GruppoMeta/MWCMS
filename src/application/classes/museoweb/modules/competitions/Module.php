<?php
class museoweb_modules_competitions_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Competitions';
        $moduleVO->name = __T('museoweb.modules.competitions.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione dei bandi e concorsi';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.competitions';
        $moduleVO->pageType = 'museoweb.modules.competitions.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.competitions.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.competitions.views.Admin" id="museoweb_Competitions" value="{i18n:Bandi e concorsi}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );
    }
}

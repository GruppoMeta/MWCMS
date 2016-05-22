<?php
class museoweb_modules_publications_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_publications';
        $moduleVO->name = __T('museoweb.modules.publications.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione delle pubblicazioni';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.publications';
        $moduleVO->pageType = 'museoweb.modules.publications.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.publications.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.publications.views.Admin" id="museoweb_publications" value="{i18n:museoweb.modules.publications.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );
    }
}

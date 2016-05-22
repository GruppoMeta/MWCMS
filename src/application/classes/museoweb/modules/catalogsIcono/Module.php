<?php
class museoweb_modules_catalogsIcono_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_CatalogsIcono';
        $moduleVO->name = __T('Documenti iconografici');
        $moduleVO->description = 'Modulo di catalogazione dei documenti iconografici';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.catalogsIcono';
        $moduleVO->pageType = 'museoweb.modules.catalogsIcono.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.catalogsIcono.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.catalogsIcono.views.Admin" id="museoweb_CatalogsIcono" value="{i18n:Documenti iconografici}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = true;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

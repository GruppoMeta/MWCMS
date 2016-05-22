<?php
class museoweb_modules_catalogsMultimedia_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_CatalogsMultimedia';
        $moduleVO->name = __T('Documenti testuali/multimediali');
        $moduleVO->description = 'Modulo di catalogazione dei documenti testuali/multimediali';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.catalogsMultimedia';
        $moduleVO->pageType = 'museoweb.modules.catalogsMultimedia.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.catalogsMultimedia.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.catalogsMultimedia.views.Admin" id="museoweb_CatalogsMultimedia" value="{i18n:Documenti testuali/multimediali}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = true;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

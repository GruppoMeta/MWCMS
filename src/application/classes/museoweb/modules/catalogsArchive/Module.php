<?php
class museoweb_modules_catalogsArchive_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_CatalogsArchive';
        $moduleVO->name = __T('Documenti d\'archivio');
        $moduleVO->description = 'Modulo di catalogazione dei documenti d\'archivio';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.catalogsArchive';
        $moduleVO->pageType = 'museoweb.modules.catalogsArchive.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.catalogsArchive.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.catalogsArchive.views.Admin" id="museoweb_CatalogsArchive" value="{i18n:Documenti d\'archivio}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = true;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

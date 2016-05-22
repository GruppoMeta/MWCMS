<?php
class museoweb_modules_catalogs_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Catalogs';
        $moduleVO->name = __T('Catalog');
        $moduleVO->description = 'Modulo di catalogazione delle opere';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.catalogs';
        $moduleVO->pageType = 'museoweb.modules.catalogs.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.catalogs.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.catalogs.views.Admin" id="museoweb_Catalogs" value="{i18n:Catalog}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = true;

        org_glizy_Modules::addModule( $moduleVO );
        org_glizy_plugins_PluginManager::addPlugin('org.glizy.plugins.Search', 'museoweb.modules.catalogs.Search');

    }
}

<?php
class museoweb_modules_mediaArchiveExplorer_Module
{
    static function registerModule()
    {
        $classPath = 'museoweb.modules.mediaArchiveExplorer';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_mediaArchiveExplorer';
        $moduleVO->name = __T('Esplora Archivio Media');
        $moduleVO->description = 'Modulo che consente di esplorare e scaricare i file dall\'Archivio Media';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = '';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.mediaArchiveExplorer.views.Admin" id="museoweb_modules_mediaArchiveExplorer" parentId="MediaArchive" value="{i18n:Esplora Archivio Media}" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

<?php
class museoweb_modules_projects_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_projects';
        $moduleVO->name = __T('museoweb.modules.projects.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione dei progetti';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.projects';
        $moduleVO->pageType = 'museoweb.modules.projects.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.projects.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.projects.views.Admin" id="museoweb_projects" value="{i18n:museoweb.modules.projects.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );
    }
}

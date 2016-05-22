<?php
class museoweb_modules_news_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_News';
        $moduleVO->name = __T('museoweb.modules.news.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione delle news';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.news';
        $moduleVO->pageType = 'museoweb.modules.news.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.news.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.news.views.Admin" id="museoweb_News" value="{i18n:museoweb.modules.news.views.FrontEnd}" icon="icon-circle-blank" adm:acl="*" />';

        org_glizy_Modules::addModule( $moduleVO );
    }
}


<?php
class museoweb_modules_exhibitions_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Exhibitions';
        $moduleVO->name = __T('museoweb.modules.exhibitions.views.FrontEnd');
        $moduleVO->description = 'Modulo di gestioe delle mostre';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.exhibitions';
        $moduleVO->pageType = 'museoweb.modules.exhibitions.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.exhibitions.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.exhibitions.views.Admin" id="museoweb_Exhibitions" value="{i18n:Mostre}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

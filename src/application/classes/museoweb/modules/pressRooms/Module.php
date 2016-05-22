<?php
class museoweb_modules_pressRooms_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_pressRoom';
        $moduleVO->name = __T('museoweb.modules.pressRooms.views.FrontEnd');
        $moduleVO->description = 'Modulo per la gestione delle rassegne stampa';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.pressRooms';
        $moduleVO->pageType = 'museoweb.modules.pressRooms.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.pressRooms.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.pressRooms.views.Admin" id="museoweb_PressRoom" value="{i18n:Rassegna stampa}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}
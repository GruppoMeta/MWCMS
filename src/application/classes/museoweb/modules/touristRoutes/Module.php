<?php
class museoweb_modules_touristRoutes_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_TouristRoutes';
        $moduleVO->name = __T('TouristRoutes');
        $moduleVO->description = 'Modulo per la gestione degli itinerari';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.touristRoutes';
        $moduleVO->pageType = 'museoweb.modules.touristRoutes.views.RoutesFrontEnd';
        $moduleVO->model = 'museoweb.modules.touristRoutes.models.Route';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page id="museoweb_TouristRoutes_alias" value="{i18n:TouristRoute}" icon="icon-circle-blank" adm:acl="*" adm:aclPageTypes="museoweb_TouristRoutes,museoweb_TouristSite" select="*">'.
                                    '<glz:Page pageType="museoweb.modules.touristRoutes.views.AdminRoutes" id="museoweb_TouristRoutes" value="{i18n:TouristRoutes}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.touristRoutes.views.AdminSites" id="museoweb_TouristSite" value="{i18n:TouristSite}" icon="icon-circle-blank" />'.
                                    '</glz:Page>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_TouristRoutesSearch';
        $moduleVO->name = __T('TouristSites');
        $moduleVO->description = 'Modulo per la gestione degli itinerari';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.touristRoutes';
        $moduleVO->pageType = 'museoweb.modules.touristRoutes.views.SitesFrontEnd';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        org_glizy_Modules::addModule( $moduleVO );
    }
}

<?php
class museoweb_modules_routes_Module
{
    const MW_RouteGroups = 'routegroup_id';
    const MW_RouteThemes = 'routetheme_id';
    const MW_Routes = 'route_id';

    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Routes';
        $moduleVO->name = __T('Routes');
        $moduleVO->description = 'Modulo per la gestione dei percorsi tematici';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.routes';
        $moduleVO->pageType = 'museoweb.modules.routes.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.routes.models.Route';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page id="museoweb_Routes_alias" value="{i18n:Routes}" icon="icon-circle-blank" select="museoweb_RoutesGroups" adm:acl="*" adm:aclPageTypes="museoweb_RoutesGroups,museoweb_RoutesThemes,museoweb_Routes">'.
                                    '<glz:Page pageType="museoweb.modules.routes.views.AdminGroups" id="museoweb_RoutesGroups" value="{i18n:GroupsOfRoutes}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.routes.views.AdminThemes" id="museoweb_RoutesThemes" value="{i18n:Routes_2}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.routes.views.AdminRoute" id="museoweb_Routes" value="{i18n:Topics}" icon="icon-circle-blank" />'.
                                    '</glz:Page>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}
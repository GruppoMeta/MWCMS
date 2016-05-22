<?php
class museoweb_modules_mountings_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Mountings';
        $moduleVO->name = 'Allestimenti';
        $moduleVO->description = 'Modulo di catalogazione degli allestimenti';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.mountings';
        $moduleVO->pageType = 'museoweb.modules.mountings.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.mountings.models.Mounting';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page id="museoweb_Mountings_alias" value="{i18n:Mounting}" icon="icon-circle-blank" select="*" adm:acl="*" adm:aclPageTypes="museoweb_Mountings,museoweb_MountingsParts">'.
                                    '<glz:Page pageType="museoweb.modules.mountings.views.AdminMounting" id="museoweb_Mountings" value="{i18n:Mounting}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.mountings.views.AdminMountingParts" id="museoweb_MountingsParts" value="{i18n:MW_MOUNTING_INTERVENTION_ELEMENTS}" icon="icon-circle-blank" />'.
                                    '</glz:Page>';

        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );
    }
}
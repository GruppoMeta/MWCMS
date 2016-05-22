<?php
class museoweb_modules_ecommerce_Module
{
    private static $helper = null;

    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_ecommerce';
        $moduleVO->name = __T('museoweb.modules.ecommerce.views.FrontEnd');
        $moduleVO->description = 'Modulo per l\'ecommerce';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.ecommerce';
        $moduleVO->pageType = 'museoweb.modules.ecommerce.views.FrontEnd';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page id="museoweb_ecommerce_alias" value="{i18n:museoweb.modules.ecommerce.views.FrontEnd}" icon="icon-circle-blank" select="museoweb_ecommerceCatalog" adm:acl="*" adm:aclPageTypes="museoweb_ecommerceCatalog,museoweb_ecommerceLicences,museoweb_ecommerceOrders">'.
                            '<glz:Page pageType="museoweb.modules.ecommerce.views.AdminCatalog" id="museoweb_ecommerceCatalog" value="{i18n:Impostazioni}" icon="icon-circle-blank" />'.
                            '<glz:Page pageType="museoweb.modules.ecommerce.views.AdminLicences" id="museoweb_ecommerceLicences" value="{i18n:Licences}" icon="icon-circle-blank" />'.
                            /*'<glz:Page pageType="museoweb.modules.ecommerce.views.AdminOrders" id="museoweb_ecommerceOrders" value="{i18n:Orders}" icon="icon-circle-blank" />'.*/
                            '</glz:Page>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );

        $application = org_glizy_ObjectValues::get('org.glizy', 'application');
        if ($application && !$application->isAdmin()) {
            self::$helper = org_glizy_ObjectFactory::createObject('museoweb.modules.ecommerce.Helper');
        }
    }
}

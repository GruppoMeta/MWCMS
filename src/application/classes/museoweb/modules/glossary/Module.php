<?php
class museoweb_modules_glossary_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Glossary';
        $moduleVO->name = __T('museoweb.modules.glossary.views.FrontEnd');
        $moduleVO->description = 'Modulo di gestioe del glossario';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.glossary';
        $moduleVO->pageType = 'museoweb.modules.glossary.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.glossary.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.glossary.views.Admin" id="museoweb_Glossary" value="{i18n:Glossario}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}

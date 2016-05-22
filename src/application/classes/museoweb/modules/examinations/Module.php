<?php
class museoweb_modules_examinations_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_Examination';
        $moduleVO->name = __T('museoweb.modules.examinations.views.FrontEnd');
        $moduleVO->description = 'Modulo spoglio';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.examinations';
        $moduleVO->pageType = 'museoweb.modules.examinations.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.examinations.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.examinations.views.Admin" id="museoweb_Examinations" value="{i18n:Spoglio}" icon="icon-circle-blank" adm:acl="*" />';
        org_glizy_Modules::addModule( $moduleVO );
    }
}

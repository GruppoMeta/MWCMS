<?php
class museoweb_modules_newsletter_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_newsletter';
        $moduleVO->name = __T('Newsletter');
        $moduleVO->description = 'Modulo per la gestione delle newsletter';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.newsletter';
        // $moduleVO->pageType = 'museoweb.modules.newsletter.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.newsletter.models.Newsletter';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page id="museoweb_newsletter_alias" value="{i18n:Newsletter}" icon="icon-circle-blank" select="museoweb_newsletter" adm:acl="*" adm:aclPageTypes="museoweb_newsletter,museoweb_newsletterSender,museoweb_sendNewsletter">'.
                                    '<glz:Page pageType="museoweb.modules.newsletter.views.AdminNewsletter" id="museoweb_newsletter" value="{i18n:MW_NEWSLETTER_LIST_TITLE}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.newsletter.views.AdminSenders" id="museoweb_newsletterSender" value="{i18n:MW_SM_SENDER_LIST}" icon="icon-circle-blank" />'.
                                    '<glz:Page pageType="museoweb.modules.newsletter.views.AdminSendNewsletter" id="museoweb_sendNewsletter" value="{i18n:MW_SM_SEND_NEWSLETTER}" icon="icon-circle-blank" />'.
                                    '</glz:Page>';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );
    }
}
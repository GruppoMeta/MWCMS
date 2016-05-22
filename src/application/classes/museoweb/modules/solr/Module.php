<?php
class museoweb_modules_solr_Module
{
    const EVT_INDEX_MODEL = 'mwcmsSolrIndexModel';
    const EVT_QUEUE_MODEL = 'mwcmsSolrQueueModel';
    const EVT_QUEUE_COMMIT = 'mwcmsSolrQueueCommit';
    const EVT_DELETE_MODEL = 'mwcmsSolrDeleteModel';
    CONST REGISTRY_SOLR_MAP_ACTIVE = '/solr/mapping/activeModules';
    CONST REGISTRY_SOLR_ENABLED = '/solr/enabled';
    CONST REGISTRY_SOLR_MAP = '/solr/mapping';
    CONST REGISTRY_SOLR_PROFILE = '/solr/profile';

    static function registerModule()
    {
        $classPath = 'museoweb.modules.solr';
        glz_loadLocale($classPath);

        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_modules_solr';
        $moduleVO->name = 'SOLR';
        $moduleVO->description = 'Modulo di amministrazione SOLR';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = $classPath;
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = '';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.solr.views.Admin" id="museoweb_modules_solr" parentId="glizycms_system" value="{i18n:Amministrazione SOLR}" adm:acl="a" />';
        $moduleVO->canDuplicated = false;

        org_glizy_Modules::addModule( $moduleVO );

        it_gruppometa_metacms_modules_solr_Solr::fixUrl();
        $listener = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.Listener');
    }

    static function getSolrProfile()
    {
        $profile = (unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').
                                            self::REGISTRY_SOLR_PROFILE)) ?: array());
        return $profile;
    }
}

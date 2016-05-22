<?php
class museoweb_modules_pico_Module
{
    const EVT_INDEX_MODEL = 'mwcmsPicoIndexModel';
    const EVT_DELETE_MODEL = 'mwcmsPicoDeleteModel';
    public static $mapping = array();
    public static $mappingToModule = array();
    public static $mappingToModel = array();
    public static $mappingToLabel = array();


    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_pico';
        $moduleVO->name = __T('Pico');
        $moduleVO->description = 'Modulo per la gestione di PICO';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.pico';
        $moduleVO->pageType = '';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.pico.views.Admin" id="museoweb_pico" parentId="glizycms_system"  value="{i18n:Impostazioni Pico}" adm:acl="a" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );

        $thesaurusParser = org_glizy_ObjectFactory::createObject( 'museoweb.modules.pico.thesaurus.Parser' );
        // $thesaurusParser->parse();

        $listener = org_glizy_ObjectFactory::createObject('museoweb.modules.pico.Listener');

        $availableModules = array();
        foreach(glob(__DIR__.'/mapping/*.php') as $file) {
            $file = pathinfo($file);
            $obj = org_glizy_ObjectFactory::createObject('museoweb.modules.pico.mapping.'.$file['filename']);
            $info = $obj->getSetInfo();
            self::$mappingToModel[$info['setSpec']] = $info['model'];
            self::$mappingToModule[$info['setSpec']] = $info['module'];
            self::$mappingToLabel[$info['setSpec']] = $info['setName'];
        }

    }

    static function getMappingToModel()
    {
        return self::$mappingToModel;
    }

    static function getMappingToModule()
    {
        return self::$mappingToModule;
    }

    static function getMappingToLabel()
    {
        return self::$mappingToLabel;
    }


    static function getRegistryPath()
    {
        return __Config::get( 'BASE_REGISTRY_PATH' ).'/pico';
    }

    static function getEnabledModules()
    {
        $picoInfo = unserialize(org_glizy_Registry::get(self::getRegistryPath()));
        $modulesEnabled = $picoInfo && isset($picoInfo['modules']) ? $picoInfo['modules'] : array();
        return $modulesEnabled;
    }

    static function addSets($application)
    {
        $modulesEnabled = self::getEnabledModules();
        foreach($modulesEnabled as $k=>$v) {
            $application->addSet($k);
        }
    }

    static function setConfig()
    {
        $picoInfo = unserialize(org_glizy_Registry::get(self::getRegistryPath()));
        if ($picoInfo) {
            __Config::set('oaipmh.title', $picoInfo['title']);
            __Config::set('oaipmh.adminEmail', $picoInfo['email']);
            __Config::set('oaipmh.repositoryIdentifier', $picoInfo['identify']);
        }
    }
}

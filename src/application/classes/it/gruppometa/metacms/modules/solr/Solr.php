<?php
class it_gruppometa_metacms_modules_solr_Solr
{
	const REGISTRY_PATH = 'metacms/solr/';
	const CONFIG_URL = 'metacms.solr.url';

	static function fixUrl()
	{
		__Config::set('metacms.solr.url', rtrim(__Config::get('metacms.solr.url'), '/').'/');
	}

	static function registerModule()
	{
		$moduleVO = org_glizy_Modules::getModuleVO();
		$moduleVO->id = 'metacms.Solr';
		$moduleVO->name = 'MetaKMS';
		$moduleVO->classPath = 'it.gruppometa.metacms.modules.solr';
		$moduleVO->siteMapAdmin = '<glz:Page pageType="'.$moduleVO->classPath.'.views.SolrAdmin" id="'.$moduleVO->id.'Admin" value="SOLR" />';
		org_glizy_Modules::addModule( $moduleVO );
	}

	static function getRegistryPath()
	{
		$application = &org_glizy_ObjectValues::get('org.glizy', 'application');
		return self::REGISTRY_PATH . ( $application->isAdmin() ? $application->getEditingLanguage() : $application->getLanguage() );
	}

	static function getPreferences()
	{
		$configPref = __Config::get('metacms.solr.pref', '');

		if ($configPref)
		{
			$pref = array();
			$pref[ 'facets' ] = __Config::get('metacms.solr.facets', '');
			$pref[ 'facets' ] = $pref[ 'facets' ] ? explode(',', $pref[ 'facets' ]) : array();
			$pref[ 'fields' ] = __Config::get('metacms.solr.fields', '');
			$pref[ 'fields' ] = $pref[ 'fields' ] ? explode(',', $pref[ 'fields' ]) : array();
			$pref[ 'row_0' ] = __Config::get('metacms.solr.row_0', '');
			$pref[ 'row_1' ] = __Config::get('metacms.solr.row_1', '');
			$pref[ 'row_2' ] = __Config::get('metacms.solr.row_2', '');
			$pref[ 'row_3' ] = __Config::get('metacms.solr.row_3', '');
			$pref[ 'row_4' ] = __Config::get('metacms.solr.row_4', '');

			return $pref;
		}

		$pref = unserialize( org_glizy_Registry::get( self::getRegistryPath(), '') );
		if (empty($pref))
		{
			$pref = array();
			$pref[ 'facets' ] = array();
		}

		return $pref;
	}
}

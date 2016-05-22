<?php
class museoweb_modulesBuilder_builder_10AddSitemap extends museoweb_modulesBuilder_builder_AbstractCommand
{
	function execute()
	{
        org_glizy_Modules::deleteCache();
		org_glizy_cache_CacheFile::cleanPHP(__Paths::get('APPLICATION_TO_ADMIN_CACHE'));
		return true;
	}
}
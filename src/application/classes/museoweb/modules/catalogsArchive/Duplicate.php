<?php
class museoweb_modules_catalogsArchive_Duplicate extends museoweb_modules_catalogs_Duplicate
{
	function __construct(org_glizy_ModuleVO $moduleVO)
	{
        $this->origModuleName = 'Documenti d\'archivio';
        $this->origId = 'museoweb_CatalogsArchive';
        $this->origFolder = 'catalogsArchive';

        parent::__construct($moduleVO);
	}
}

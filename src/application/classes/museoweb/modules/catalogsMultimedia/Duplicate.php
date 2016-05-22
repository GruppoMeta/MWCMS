<?php
class museoweb_modules_catalogsMultimedia_Duplicate extends museoweb_modules_catalogs_Duplicate
{
    function __construct(org_glizy_ModuleVO $moduleVO)
    {
        $this->origModuleName = 'Documenti testuali/multimediali';
        $this->origId = 'museoweb_CatalogsMultimedia';
        $this->origFolder = 'catalogsMultimedia';
        parent::__construct($moduleVO);
    }
}

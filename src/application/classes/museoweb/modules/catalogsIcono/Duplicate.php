<?php
class museoweb_modules_catalogsIcono_Duplicate extends museoweb_modules_catalogs_Duplicate
{
    function __construct(org_glizy_ModuleVO $moduleVO)
    {
        $this->origModuleName = 'Documenti iconografici';
        $this->origId = 'museoweb_CatalogsIcono';
        $this->origFolder = 'catalogsIcono';
        parent::__construct($moduleVO);
    }
}

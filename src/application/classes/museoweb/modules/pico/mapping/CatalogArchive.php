<?php
class museoweb_modules_pico_mapping_CatalogArchive extends museoweb_modules_pico_mapping_Catalog
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.CatalogArchive';
        $info[ 'setName' ] = 'Documenti d\'archivio';
        $info[ 'setDescription' ] = 'Documenti d\'archivio';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.catalogsArchive.models.Model';
        $info[ 'module' ] = 'museoweb_CatalogsArchive';
        return $info;
    }
}
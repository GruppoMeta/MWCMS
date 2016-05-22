<?php
class museoweb_modules_pico_mapping_CatalogMultimedia extends museoweb_modules_pico_mapping_Catalog
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.CatalogMultimedia';
        $info[ 'setName' ] = 'Documenti multimediali';
        $info[ 'setDescription' ] = 'Documenti multimediali';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.catalogsMultimedia.models.Model';
        $info[ 'module' ] = 'museoweb_CatalogsMultimedia';
        return $info;
    }
}
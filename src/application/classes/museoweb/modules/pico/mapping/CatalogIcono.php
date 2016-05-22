<?php
class museoweb_modules_pico_mapping_CatalogIcono extends museoweb_modules_pico_mapping_Catalog
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.CatalogIcono';
        $info[ 'setName' ] = 'Documenti iconografici';
        $info[ 'setDescription' ] = 'Documenti iconografici';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.catalogsIcono.models.Model';
        $info[ 'module' ] = 'museoweb_CatalogsIcono';
        return $info;
    }
}
<?php
class museoweb_modules_pico_mapping_News extends museoweb_modules_pico_AbstractMapping
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.News';
        $info[ 'setName' ] = 'News';
        $info[ 'setDescription' ] = 'News';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.news.models.Model';
        $info[ 'module' ] = 'museoweb_News';
        return $info;
    }

    public function getMetadata($identifier)
    {
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->newsdetail_title, 'dc:title' );

        return $output;
    }
}
<?php
class museoweb_modules_pico_mapping_Event extends museoweb_modules_pico_AbstractMapping
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.Event';
        $info[ 'setName' ] = 'Eventi';
        $info[ 'setDescription' ] = 'Eventi';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.events.models.Model';
        $info[ 'module' ] = 'museoweb_Events';
        return $info;
    }

    public function getMetadata($identifier)
    {
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->eventdetail_title, 'dc:title' );

        return $output;
    }
}
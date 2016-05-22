<?php
class museoweb_modules_pico_mapping_RouteTheme extends museoweb_modules_pico_AbstractMapping
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.RouteTheme';
        $info[ 'setName' ] = 'Percorsi tematici';
        $info[ 'setDescription' ] = 'Percorsi tematici';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.routes.models.Theme';
        $info[ 'module' ] = 'museoweb_Routes';
        return $info;
    }

    public function getMetadata($identifier)
    {
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->routethemedetail_title, 'dc:title' );
        $output .= xmlrecord( $this->ar->routethemedetail_author, 'pico:author' );
        $output .= xmlrecord( strip_tags( $this->ar->routethemedetail_description ), 'dc:description' );
        $output .= xmlrecord( "Text", 'dc:type' );
        $output .= xmlrecord( $this->ar->document_creationDate, 'dcterms:dateIssued' );
        $output .= xmlrecord( 'IT', 'dc:language' );
        // $values = $this->ar->getValuesAsArray();
        // $values[ 'routetheme_id' ] = $this->ar->document_id;
        // $values[ 'routegroup_id' ] = $this->ar->routethemedetail_FK_routegroup_id;
        // $values[ 'route_id' ] = 0;
        // $output .= xmlrecord( $this->makeUrl( 'museoweb_RoutesTheme', $values ), 'dcterms:isReferencedBy' );

        // link catalogo
        // copyright indicato sulla pagina web

        return $output;
    }
}
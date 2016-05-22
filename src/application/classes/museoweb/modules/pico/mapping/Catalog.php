<?php
class museoweb_modules_pico_mapping_Catalog extends museoweb_modules_pico_AbstractMapping
{
    // TODO: tradurre etichette
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.Catalog';
        $info[ 'setName' ] = 'Schede di catalogazione';
        $info[ 'setDescription' ] = 'Schede di catalogazione';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.catalogs.models.Model';
        $info[ 'module' ] = 'museoweb_Catalogs';
        return $info;
    }

    public function getMetadata($identifier)
    {
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->catalogdetail_title, 'dc:title' );
        $output .= xmlrecord( $this->ar->catalogdetail_author, 'pico:author' );
        $output .= $this->getW3CDTF( $this->ar->document_creationDate );
        $output .= $this->getPostalCode( $this->ar->catalogdetail_country, $this->ar->catalogdetail_city );

        $place = "";
        if ($this->ar->catalogdetail_place ) $place .= "name=".$this->ar->catalogdetail_place;
        if ($this->ar->catalogdetail_place && $this->ar->catalogdetail_place2 ) $place .= "; ";
        if ($this->ar->catalogdetail_place2 ) $place .= "value=".$this->ar->catalogdetail_place;
        $output .= xmlrecord( $place, 'dcterms:spatial');

        $output .= xmlrecord( $this->ar->catalogdetail_collection, 'dcterms:isPartOf');
        $output .= xmlrecord( $this->ar->catalogdetail_material, 'pico:materialAndTechnique' );
        $output .= xmlrecord( $this->ar->catalogdetail_dimension, 'dcterms:extent' );
        $output .= xmlrecord( $this->ar->catalogdetail_origin, 'dcterms:provenance' );
        $output .= xmlrecord( $this->ar->catalogdetail_description, 'dc:description' );
        $output .= $this->makeThesaurus( $this->ar->catalogdetail_thesaurus );
        $output .= xmlrecord( $this->ar->catalogdetail_bibliography, 'dcterms:isReferencedBy' );
        $output .= xmlrecord( "PhysicalObject", 'dc:type' );
        $output .= xmlrecord( $this->makeUrl( 'museoweb_Catalogs', $this->ar->getValuesAsArray() ), 'dcterms:isReferencedBy' );

        $output .= $this->getImageLink( $this->ar->catalogdetail_image1 );


        if ( $this->ar->catalogdetail_FK_touristsite_id > 0)
        {
            $rsTouristSite = org_glizy_ObjectFactory::createModel( 'museoweb.modules.touristRoutes.models.Site' );
            $res = $rsTouristSite->load($this->ar->catalogdetail_FK_touristsite_id);
            if ($res)
            {
                $output .= xmlrecord( $this->makeUrlCol( 'museoweb_TouristSite', array('document_id' => $rsTouristSite->document_id, 'touristsitedetail_name' => $rsTouristSite->touristsitedetail_name ), $rsTouristSite->touristsitedetail_name) , 'dcterms:isPartOf', 'xsi:type="pico:Anchor"' );
            }
        }

        return $output;
    }

}
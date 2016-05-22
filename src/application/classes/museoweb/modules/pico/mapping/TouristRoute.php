<?php
class museoweb_modules_pico_mapping_TouristRoute extends museoweb_modules_pico_AbstractMapping
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.TouristRoute';
        $info[ 'setName' ] = 'Itinerari';
        $info[ 'setDescription' ] = 'Itinerari';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.touristRoutes.models.Route';
        $info[ 'module' ] = 'museoweb_TouristRoutes';
        return $info;
    }


    public function getMetadata($identifier)
    {
        glz_import( 'museoweb.locale.it');
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->touristroutedetail_name, 'dc:title', 'xml:lang="it"' );
        $output .= xmlrecord( $this->ar->touristroutedetail_author, 'pico:author' );
        $output .= xmlrecord( $this->ar->touristroutedetail_compilationDate, 'dcterms:dateIssued' );

        $output .= xmlrecord( strip_tags( $this->ar->touristroutedetail_path ), 'dc:description', 'xml:lang="it"'  );
        $output .= xmlrecord( "name=".__Tp( 'MW_TR_DIFFICULTY' ).";value=".$this->ar->touristroutedetail_difficulty, 'dc:description'  );
        $output .= xmlrecord( "name=".__Tp( 'MW_TR_LENGTH' ).";value=".$this->ar->touristroutedetail_length, 'dc:description'  );
        $output .= xmlrecord( "name=".__Tp( 'MW_TR_TIMELENGTH' ).";value=".$this->ar->touristroutedetail_timelength, 'dc:description'  );
        $output .= xmlrecord( "name=".__Tp( 'MW_TR_TIMELENGTH' ).";value=".$this->ar->touristroutedetail_timelength, 'dc:description'  );
        $output .= xmlrecord( strip_tags( $this->ar->touristroutedetail_description ), 'dc:description'  );
        $output .= xmlrecord( strip_tags( $this->ar->touristroutedetail_touristInfo ), 'pico:information'  );
        // $output .= xmlrecord( 'PlaceType='.$this->ar->touristroutedetail_town.'/'.$this->ar->touristroutedetail_province.'/'.$this->ar->touristroutedetail_region.'/'.$this->ar->touristroutedetail_country, 'dcterms:spatial', 'xsi:type="pico:PostalAddress"'  );
        $output .= $this->getPostalCode( array( $this->ar->touristroutedetail_country, $this->ar->touristroutedetail_region, $this->ar->touristroutedetail_province ), $this->ar->touristroutedetail_town );

        // mappa
        $output .= $this->getImageLink( $this->ar->touristroutedetail_map );
        // // link a catalogo
        // if ( $this->ar->touristroute2catalog->count() )
        // {
        //     while ($this->ar->touristroute2catalog->hasMore())
        //     {
        //         $arJoin = &$this->ar->touristroute2catalog->current();
        //         $this->ar->touristroute2catalog->next();
        //         $arCatalog = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.Catalog');
        //         $arCatalog->load( $arJoin->touristroute2catalog_FK_catalog_id );
        //         $output .= xmlrecord( $this->makeUrlCol( 'Catalog', $arCatalog->getValuesAsArray(), $arCatalog->catalogdetail_title ), 'dcterms:references', 'xsi:type="pico:Anchor"' );
        //     }
        // }

        // link alle tappe
        // $iteratorTouristSite = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.touristRoutes.models.Site',
        //                         'All', array('order' => array('touristsitedetail_name')));
        // foreach ($iteratorTouristSite as $arTouristSite) {
        //     var_dump($arTouristSite->touristsitedetail_FK_touristroute);
        //     exit;

        //     $touristsitedetail_FK_touristroute = explode(',', $arTouristSite->touristsitedetail_FK_touristroute);
        //     if (in_array( $this->ar->touristroute_id, $touristsitedetail_FK_touristroute))
        //     {
        //         $output .= xmlrecord( $this->makeUrlCol( 'touristroutes', array(MW_TouristRoute => $this->ar->touristroute_id, MW_TouristSite => $arTouristSite->touristsite_id ), $arC->touristsitedetail_name ), 'dcterms:hasPart', 'xsi:type="pico:Anchor"' );
        //     }
        // }

        $output .= xmlrecord( strip_tags( $this->ar->touristroutedetail_bibliography ), 'dcterms:isReferencedBy'  );
        $output .= xmlrecord( "Text", 'dc:type' );
//      $output .= xmlrecord( "name=".$this->ar->touristroutedetail_category.";id=".md5( strtolower( $this->ar->touristroutedetail_category ) ), 'dc:subject', 'xsi:type="pico:Thesaurus"' );
        $output .= $this->makeThesaurus( $this->ar->touristroutedetail_thesaurus );
        // dc:rights
        $output .= xmlrecord( "IT", 'dc:language' );

        $output .= xmlrecord( $this->makeUrl( 'touristroutesSearch', $this->ar->getValuesAsArray() ), 'dcterms:isReferencedBy', 'xsi:type="pico:anchor"' );
        return $output;
    }
}
<?php
class museoweb_modules_pico_mapping_TouristSite extends museoweb_modules_pico_AbstractMapping
{
    public function getSetInfo()
    {
        $info = parent::getSetInfo();
        $info[ 'setSpec' ] = 'museoweb.modules.pico.mapping.TouristSite';
        $info[ 'setName' ] = 'Siti e monumenti';
        $info[ 'setDescription' ] = 'Siti e monumenti';
        $info[ 'setCreator' ] = 'MiBAC';
        $info[ 'model' ] = 'museoweb.modules.touristRoutes.models.Site';
        $info[ 'module' ] = 'museoweb_TouristRoutes';
        return $info;
    }

    public function getMetadata($identifier)
    {
        $output = "";
        $output .= xmlrecord( $identifier, 'dc:identifier', '', 0, false );
        $output .= xmlrecord( $this->ar->touristsitedetail_name, 'dc:title', 'xml:lang="it"' );
        $output .= xmlrecord( $this->ar->touristsitedetail_author, 'pico:author' );
        $output .= xmlrecord( $this->ar->touristsitedetail_compilationDate, 'dcterms:dateIssued' );

        $output .= xmlrecord( strip_tags( $this->ar->touristsitedetail_description ), 'dc:description', 'xml:lang="it"'  );
        $output .= xmlrecord( "name=come arrivare; value=".strip_tags( $this->ar->touristsitedetail_address ), 'dc:description' );
        $output .= xmlrecord( strip_tags( $this->ar->touristsitedetail_cronology ), 'dcterms:temporal' );
        $output .= xmlrecord( strip_tags( $this->ar->touristsitedetail_touristInfo ), 'pico:information' );
        $output .= $this->getPostalCode( array( $this->ar->touristsitedetail_country, $this->ar->touristsitedetail_region, $this->ar->touristsitedetail_province ), $this->ar->touristsitedetail_town );

        // immagine
        if (count($this->ar->images->image_id)) {
            $output .= $this->getImageLink( json_decode($this->ar->images->image_id[0])->id );
        }

        // link a catalogo
        // if ( $this->ar->touristsite2catalog->count() )
        // {
        //     while ($this->ar->touristsite2catalog->hasMore())
        //     {
        //         $arJoin = &$this->ar->touristsite2catalog->current();
        //         $this->ar->touristsite2catalog->next();
        //         $arCatalog = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.Catalog');
        //         $arCatalog->load( $arJoin->touristroute2catalog_FK_catalog_id );
        //         $output .= xmlrecord( $this->makeUrlCol( 'Catalog', $arCatalog->getValuesAsArray(), $arCatalog->catalogdetail_title ), 'dcterms:references', 'xsi:type="pico:Anchor"' );
        //     }
        // }

        // itinerari collegati
        // $ar = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristRoute');
        // $it = $ar->loadQuery('All', array('filters' => array('touristroute_id IN ('.$this->ar->touristsitedetail_FK_touristroute.')', 'touristroutedetail_versionStatus' => 'PUBLISHED', 'touristroutedetail_FK_language_id' => $this->ar->touristsitedetail_FK_language_id), 'order' => array('touristroutedetail_name')));
        // while ($it->hasMore())
        // {
        //     $arC = &$it->current();
        //     $it->next();
        //     $output .= xmlrecord( $this->makeUrlCol( 'touristroutes', array(MW_TouristRoute => $arC->touristroute_id, MW_TouristSite => '0'),$arC->touristroutedetail_name ), 'dcterms:references', 'xsi:type="pico:anchor"' );
        // }
        $output .= xmlrecord( strip_tags( $this->ar->touristsitedetail_bibliography ), 'dcterms:isReferencedBy' );
        $output .= xmlrecord( "Text", 'dc:type' );
//      $output .= xmlrecord( "name=".$this->ar->touristsitedetail_category.";id=".md5( strtolower( $this->ar->touristroutedetail_category ) ), 'dc:subject', 'xsi:type="pico:Thesaurus"' );
        $output .= $this->makeThesaurus( $this->ar->touristsitedetail_thesaurus );
        $output .= xmlrecord( "IT", 'dc:language' );
        $output .= xmlrecord( $this->makeUrl( 'touristsites', $this->ar->getValuesAsArray() ), 'dcterms:isReferencedBy', 'xsi:type="pico:anchor"' );
        return $output;
    }
}
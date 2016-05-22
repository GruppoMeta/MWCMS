<?php
class museoweb_modules_pico_AbstractMapping extends org_glizy_oaipmh_core_AbstractMapping
{
    public function getRecord($identifier)
    {
        $output = '<pico:record xmlns:pico="http://purl.org/pico/1.0/" '.
'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.
'xmlns:dc="http://purl.org/dc/elements/1.1/" '.
'xmlns:dcterms="http://purl.org/dc/terms/" '.
'xsi:schemaLocation="http://purl.org/pico/1.0/ http://www.culturaitalia.it/pico/schemas/1.0/pico.xsd '.
'http://purl.org/dc/elements/1.1/ http://www.dublincore.org/schemas/xmls/qdc/2006/06/01/dc.xsd '.
'http://purl.org/dc/terms/ http://www.dublincore.org/schemas/xmls/qdc/2006/01/06/dcterms.xsd">';
        $output .= $this->getMetadata($identifier);
        $output .= '</pico:record>';
        return $output;
    }

    public function loadRecord( $id )
    {
        $this->ar               = org_glizy_ObjectFactory::createModel( $this->getModelName() );
        return $this->ar->load($id);
    }

    protected function makeThesaurus( $thesaurus )
    {
        $thesaurus = str_replace( '__pico__', '', $thesaurus );
        $thesaurus = explode( ',', $thesaurus );
        $output = "";
        foreach( $thesaurus as $v )
        {
            $v = preg_replace( '/("[^"]*)/', '', $v );
            $output .= xmlrecord( $v, 'dc:subject', 'xsi:type="pico:Thesaurus"' );
        }
        return $output;
    }



    protected function makeUrl( $route, $args )
    {
        $url = __Link::makeUrl( $route, $args );
        $url = str_replace( "/oaipmh/", "", $url );
        return "title=vai alla pagina web relativa; URL=".$url ;
    }

    protected function makeUrlCol( $route, $args, $name )
    {
        $url = __Link::makeUrl( $route, $args );
        $url = str_replace( "/oaipmh/", "", $url );
        return "name=".$name."; URL=".$url ;
    }

    protected function getImageLink( $id )
    {
        if ( $id > 0 )
        {
            $url = str_replace( "/oaipmh", "", GLZ_HOST).'/getImage.php?id='.$id.'&w=320&h=240&f=0';
        }
        else
        {
            $url = str_replace( "/oaipmh", "", GLZ_HOST).'/static/museoweb/assets/images/noimage.jpg';
        }

        return xmlrecord( $url, 'pico:preview', 'xsi:type="dcterms:URI"' );
    }

    protected function getW3CDTF( $d )
    {
        list( $d ) = explode( ' ', glz_localeDate2default( $d ) );
        return xmlrecord( $d, 'dcterms:created', 'xsi:type="dcterms:W3CDTF"' );
    }

    protected function getPostalCode( $address, $city='' )
    {
        if ( is_string( $address ) )
        {
            $address = split( ',', $address );
        }
        if ( count( $address ) >= 3 )
        {
            $country = array_shift( $address );
            $region = array_shift( $address );
            $province = array_shift( $address );
            if ( !empty( $city ) )
            {
                $city = ';City='.$city;
            }

            return xmlrecord( 'Country='.$country.'; Region='.$region.'; Province='.$province.$city, 'dcterms:spatial', 'xsi:type="pico:PostalAddress"' );
        }

        return "";
    }
}


function xmlrecord($str, $element, $attr = '', $indent = 0, $split = true )
{
    if ($attr != '') {
        $attr = ' '.$attr;
    }
    if ($str != '') {
        // if (isset($SQL['split']) && $split ) {
        //     $temparr = explode($SQL['split'], $sqlrecord);
        //     foreach ($temparr as $val) {
        //         $str .= str_pad('', $indent).'<'.$element.$attr.'>'.xmlstr($val, CHARSET, XMLESCAPED).'</'.$element.">\n";
        //     }
        //     return $str;
        // } else {
            return str_pad('', $indent).'<'.$element.$attr.'>'.org_glizy_oaipmh_OaiPmh::encode($str).'</'.$element.">\n";
        // }
    } else {
        return '';
    }
}


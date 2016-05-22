<?php
class it_gruppometa_metacms_modules_solr_views_components_SolrSearch extends org_glizy_components_ComponentContainer
{
    protected $sessionEx;
    protected $result;
    protected $facets;

    function init()
    {
        $this->defineAttribute('recordBoxId', true,    '', COMPONENT_TYPE_STRING);
        $this->defineAttribute('condition', false,    '', COMPONENT_TYPE_STRING);
        parent::init();
    }

    function process()
    {
        if (!$this->_application->isAdmin() ) {
            $this->sessionEx     = new org_glizy_SessionEx($this->getId());
            $this->facets = $this->sessionEx->get( 'facet', array() );

            // controlla se sono da aggiungere delle faccette alla ricerca
            $facet = __Request::get( 'facet', '' );
            $facetAction = __Request::get( 'facetAction', '' );
            if ( $facetAction && $facet )
            {
                if ( $facetAction == 'add' )
                {
                    if ( !in_array( $facet, $this->facets ) )
                    {
                        $this->facets[] = $facet;
                    }
                }
                else if ( $facetAction == 'remove' )
                {
                    $this->facets = array_merge(array_diff($this->facets, array( $facet )));
                }
            }
            $this->sessionEx->set( 'facet', $this->facets );

            $recordBoxClass = $this->getComponentById( $this->getAttribute('recordBoxId') );
            $query = $recordBoxClass->getAttribute('query');

            $c = $this->getComponentById( 'filters' );
            $c->process();

            $fieldText = $c->loadContent( 'search' );
            if ( !empty( $fieldText ) || !empty($query)) {
                $this->doSearch( $fieldText );
            }
        }

        parent::process();
    }


    public function getResult()
    {
        return $this->result;
    }

    public function getFacets()
    {
        return $this->facets;
    }

    protected function doSearch( $search )
    {
        $paginateClass = $this->getComponentById( 'paginate' );
        $paginateClass->setRecordsCount();
        $limits = $paginateClass->getLimits();
        $recordBoxClass = $this->getComponentById( $this->getAttribute('recordBoxId') );

        $language = $this->_application->getLanguage();
        $rows = $recordBoxClass->getAttribute('numRecord');
        $sort = urlencode($recordBoxClass->getAttribute('sort'));
        $query = urlencode($recordBoxClass->getAttribute('query').' '.$search);
        $fields = urlencode($recordBoxClass->getAttribute('fields'));
        $condition = $this->getAttribute('condition');

        $url = rtrim(__Config::get( it_gruppometa_metacms_modules_solr_Solr::CONFIG_URL ), '/');
        $url .= '/select?wt=json&version=2.2&start='.$limits['start'].'&rows='.$limits['pageLength'].'&indent=on&q='.$query.'+lang_s:'.$language.$condition.'&sort='.$sort;
        $url .= '&fl='.$fields;

        // aggiuge le faccette
        $url .= '&facet=true';

        // $facetClass = $this->getComponentById( 'facet' );
        // $facetFields = explode(',', $facetClass->getAttribute('fields'));
        // foreach($facetFields as $v ) {
        //     $url .= '&facet.field='.$v;
        // }

        $profile = museoweb_modules_solr_Module::getSolrProfile();
        foreach ($profile as $k=>$v) {
            if ($profile->{$k}->facets) {
                $url .= '&facet.field='.$k.'_facet';
            }
        }

        // controlla se sono da aggiungere faccette alla ricerca
        foreach( $this->facets as $f )
        {
            $url .= '&fq='.urlencode( $f );
        }

        $this->result = @json_decode(file_get_contents( $url ));
        $numFound = intval( $this->result->response->numFound );
        $paginateClass->setRecordsCount($numFound);
        return $numFound;
    }
}

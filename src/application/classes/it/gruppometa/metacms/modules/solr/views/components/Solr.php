<?php
class it_gruppometa_metacms_modules_solr_views_components_Solr extends org_glizy_components_ComponentContainer
{
	protected $sessionEx;
	protected $dom;
	protected $facets;

	function process()
	{
		$this->sessionEx 	= new org_glizy_SessionEx($this->getId());
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

		$c = $this->getComponentById( 'filters' );
		$c->process();
		$fieldText = $c->loadContent( 'fieldText' );
		if ( !empty( $fieldText ) )
		{
			$this->doSearch( $fieldText );
		}
		$this->processChilds();
	}


	public function getDom()
	{
		return $this->dom;
	}

	public function getFacets()
	{
		return $this->facets;
	}

	protected function doSearch( $search )
	{
		$pref = it_gruppometa_metacms_modules_solr_Solr::getPreferences();

		$paginateClass = $this->getComponentById( 'paginate' );
		$paginateClass->setRecordsCount();
		$limits = $paginateClass->getLimits();

		$start = $limits[ 'start' ];
		$url = __Config::get( it_gruppometa_metacms_modules_solr_Solr::CONFIG_URL );
		$url .= 'select?version=2.2&start=##start##&rows=10&indent=on&q=##search##&sort=score%20desc';
		$url .= '&fl='.implode($pref['fields'], ',');

		// aggiuge le faccette
		$url .= '&facet=true'; //'&facet.field=dc_spatial_facet&facet.field=cosa_1_facet&facet.field=dc_creator_facet';
		foreach( $pref[ 'facets' ] as $v )
		{
			$url .= '&facet.field='.$v;
		}

		// controlla se sono da aggiungere faccette alla ricerca
		foreach( $this->facets as $f )
		{
			$url .= '&fq='.urlencode( $f );
		}

		$url = str_replace( array( '##start##', '##search##' ), array( $start, urlencode( $search ) ), $url );
		$xmlString = file_get_contents( $url );

		$this->dom = new DomDocument();
		$this->dom->loadXml( $xmlString );
		$resultNode = $this->dom->getElementsByTagName( 'result' )->item(0);
		$paginateClass->setRecordsCount(intval( $resultNode->getAttribute( 'numFound' ) ));
	}
}

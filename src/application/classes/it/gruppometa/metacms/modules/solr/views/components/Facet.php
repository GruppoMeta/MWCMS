<?php
class it_gruppometa_metacms_modules_solr_views_components_Facet extends org_glizy_components_Component
{
	var $_dataProvider;
	var $_totalRecord;
	var $_currentRecord;


	/**
	 * Init
	 *
	 * @return	void
	 * @access	public
	 */
	function init()
	{
		$this->defineAttribute('title', 		false,	'',		COMPONENT_TYPE_STRING);
		parent::init();
	}

	function process()
	{
		$this->_content 			= array();
		$this->_content['title'] 	= $this->getAttributeString('title');
		$this->_content['selected'] = null;
		$this->_content['facetLabel'] 	= null;
		$this->_content['facet'] 	= null;

		$dom = $this->_parent->getDom();

		if ( is_object( $dom ) )
		{
			$pref = it_gruppometa_metacms_modules_solr_Solr::getPreferences();

			$addedFacet = array();
			$facetFields = $pref[ 'facets' ];
			$facets = $this->_parent->getFacets();
			$this->_content['selected'] = array();
			$this->_content['facetLabel'] = array();
			$lstNodes = $dom->getElementsByTagName( 'lst' );
			foreach( $lstNodes as $n )
			{
				foreach( $facetFields as $f )
				{
					$label = __T($f);
					if ( $n->getAttribute( 'name' ) == $f && !in_array( $f, $addedFacet ) )
					{
						$addedFacet[] = $f;
						$this->_content['facetLabel'][] = array( 'id' => $f, 'title' => $label );
						$this->_content['facet'][ $f ] = array();

						foreach( $n->childNodes as $int )
						{
							$value = (int)$int->nodeValue;
							if ( $value > 0 && count( $this->_content['facet'][ $f ] ) < 8 )
							{
								$name = utf8_decode( $int->getAttribute( 'name' ) );
								$facetToAdd = $f.':"'.$name.'"';
								if ( in_array( $facetToAdd, $facets ) )
								{
									$this->_content['selected'][] = __Link::makeLink( 'solr_removefacet', array(
											'title' => __T( 'Rimuovi filtro: ').$name,
											'label' => $label.': '.$name
										),
										array(
											'facet' => urlencode( $facetToAdd )
										) );
									$this->_content['facet'][ $f ][] = $name.' ('.$value.')';
								}
								else
								{
									$this->_content['facet'][ $f ][] = __Link::makeLink( 'solr_addfacet', array(
											'title' => __T( 'Aggiungi filtro: ').$name,
											'label' => $name.' ('.$value.')',
										),
										array(
											'facet' => urlencode( $facetToAdd )
										) );
								}
							}
						}
					}
				}
			}
		}
	}

	function render( $mode )
	{
		if ( $mode != 'jsediting' )
		{
			parent::render();
		}
	}
}

if (!class_exists('it_gruppometa_metacms_modules_solr_views_components_Facet_render'))
{
	class it_gruppometa_metacms_modules_solr_views_components_Facet_render extends org_glizy_components_render_Render
	{
		function getDefaultSkin()
		{
			$skin = <<<EOD
<div class="solr solrFacet" tal:condition="php: !is_null(Component['facetLabel'])">
	<h3 tal:content="structure Component/title" />
	<span tal:omit-tag="" tal:condition="php: count(Component['selected'])">
		<h4>Filtri applicati:</h4>
		<ul class="selected">
			<li tal:repeat="item Component/selected" tal:content="structure item" />
		</ul>
	</span>
	<span tal:omit-tag="" tal:repeat="item Component/facetLabel">
		<span tal:omit-tag="" tal:condition="php: count( Component['facet'][item['id']] )">
			<h4 tal:content="structure item/title" />
			<ul>
				<li tal:repeat="item2 php:Component['facet'][item['id']]" tal:content="structure item2" />
			</ul>
		</span>
	</span>
</div>
EOD;
			return $skin;
		}
	}
}
?>
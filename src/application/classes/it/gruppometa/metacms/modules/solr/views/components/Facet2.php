<?php
class it_gruppometa_metacms_modules_solr_views_components_Facet2 extends org_glizy_components_Component
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
	    $this->defineAttribute('fields', 		false,	'',		COMPONENT_TYPE_STRING);
		parent::init();

        $profile = museoweb_modules_solr_Module::getSolrProfile();
        $dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
        $dcFields = $dcProxy->getFields();
        $fields = array();
        $locale = array();
        foreach ($profile as $k=>$v) {
            if ($profile->{$k}->facets) {
                $fields[] = $k.'_facet';
                $locale[$k.'_facet'] = $profile->{$k}->title;
            }
        }

        org_glizy_locale_Locale::append($locale);
        $this->setAttribute('fields', implode($fields, ','));
	}

	function process()
	{
		$this->_content 			= array();
		$this->_content['title'] 	= $this->getAttributeString('title');
		$this->_content['selected'] = null;
		$this->_content['facetLabel'] = null;
		$this->_content['facet'] 	= null;

        $result = $this->_parent->getResult();

        if ($result->facet_counts->facet_fields) {

            $addedFacet = array();
            $facetFields = explode(',', $this->getAttribute('fields'));
    		$facets = $this->_parent->getFacets();
    		$this->_content['selected'] = array();
            $this->_content['facetLabel'] = array();
    		$this->_content['facetNum'] = 0;

            foreach ($result->facet_counts->facet_fields as $facetName => $facetValues) {
                $label = __T($facetName);
    			$this->_content['facetLabel'][] = array( 'id' => $facetName, 'title' => $label );
    			$this->_content['facet'][ $facetName ] = array();

                for ($i = 0; $i < count($facetValues); $i+=2) {
                    $value = $facetValues[$i+1];

                    if ( $value > 0 && count( $this->_content['facet'][ $facetName ] ) < 8 )
    				{
                        $name = $facetValues[$i];
                        if (!$name) continue;
                        $this->_content['facetNum']++;
    					$facetToAdd = $facetName.':"'.$name.'"';
    					if ( in_array( $facetToAdd, $facets ) )
    					{
    						$this->_content['selected'][] = __Link::makeLink( 'solr_removefacet', array(
    								'title' => __T( 'Rimuovi filtro: ').$name,
    								'label' => $label.': '.$name
            						),
            						array(
            							'facet' => $facetToAdd,
                                        'paginate_pageNum' => 1
            						), '', false );
    						$this->_content['facet'][ $facetName ][] = $name.' ('.$value.')';
    					}
    					else
    					{
        					$this->_content['facet'][ $facetName ][] = __Link::makeLink( 'solr_addfacet', array(
    								'title' => __T( 'Aggiungi filtro: ').$name,
    								'label' => $name.' ('.$value.')'
            						),
            						array(
            							'facet' => $facetToAdd,
                                        'paginate_pageNum' => 1
            						), '', false );
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

if (!class_exists('it_gruppometa_metacms_modules_solr_views_components_Facet2_render'))
{
	class it_gruppometa_metacms_modules_solr_views_components_Facet2_render extends org_glizy_components_render_Render
	{
		function getDefaultSkin()
		{
			$skin = <<<EOD
<div class="solr solrFacet" tal:condition="php: !is_null(Component['facetLabel']) && Component['facetNum']">
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
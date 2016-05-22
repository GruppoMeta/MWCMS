<?php
class it_gruppometa_metacms_modules_solr_views_components_SolrAdmin extends org_glizy_components_Component
{
	private $facets;
	private $fields;



	function process()
	{
		$this->_content = it_gruppometa_metacms_modules_solr_Solr::getPreferences();
		$this->retrieveStructure();
	}

	function render()
	{
		$output = '';

		$this->_application->_rootComponent->addOutputCode(org_glizy_helpers_JS::linkStaticJSfile( 'jquery/jquery.tagInput/jquery.timers.js' ), 'head' );
		$this->_application->_rootComponent->addOutputCode(org_glizy_helpers_JS::linkStaticJSfile( 'jquery/jquery.tagInput/jquery.tagInput.js' ), 'head' );
		$this->_application->_rootComponent->addOutputCode(org_glizy_helpers_CSS::linkStaticCSSfile( 'jquery/jquery.tagInput/jquery.tagInput.css' ), 'head' );
		$this->_application->_rootComponent->addOutputCode(org_glizy_helpers_JS::linkStaticJSfile( 'jquery/jquery.simplemodal/jquery.simplemodal.1.4.1.min.js' ), 'head' );

		// elenco campi da includere nella ricerca
		$output .= '<h4>Composizione risultato della ricerca</h4>';
		$output .= '<p>Comporre il risultato della ricerca utilizzando i campi disponibili, durante la compilazione i campi saranno suggeriti tramite la funzione di autocompletamento, è anche possibile aggiungere caratteri o parole aggiuntive queste verranno mantenute.</p>';

		$tags = array();
		foreach( $this->fields as $f )
		{
			$tags[] = array( 'tag' => $f, 'freq'=> 0 );
		}
		$tags = json_encode( $tags );
		$output .= org_glizy_helpers_Html::hidden( 'fields' , implode( ',', $this->fields ) );
		$output .= '<p>Elenco campi disponibili: <span class="solrAvailableFields">'.implode( ' ', $this->fields ).'</span></p>';

		for ( $i = 0; $i < 5; $i++ )
		{
			$attributes = array();
			$attributes['id'] 			= 'row_'.$i;
			$attributes['name'] 		= 'row_'.$i;
			$attributes['type'] 		= 'text';
			$attributes['autocomplete']	= 'off';
			$attributes['size'] 		= 75;
			$attributes['value'] 		= isset( $this->_content[ 'row_'.$i ] ) ? $this->_content[ 'row_'.$i ] : '';
			$attributes['class'] 		= 'inputTag';
			$tmp  = '<input '.$this->_renderAttributes($attributes).'/>';
			$tmp = org_glizy_helpers_Html::label( 	$i == 0 ? 'Campo link della risorsa' : 'Riga #'.$i,
													$attributes['id'],
													false,
													$tmp,
													array( 'class' => $i < 2 ? 'required' : '' ) );
			$output .= org_glizy_helpers_Html::applyItemTemplate( $tmp, false );
		}

		// elenco faccette
		$output .= '<h4>Elenco faccette disponibili</h4>';
		$output .= '<p>Per ogni faccetta che si desidera utilizzare inserire l\'etichetta.</p>';
		foreach( $this->facets as $f )
		{
			$attributes = array();
			$attributes['id'] 			= $f;
			$attributes['name'] 		= $f;
			$attributes['type'] 		= 'text';
			$attributes['size'] 		= 75;
			$attributes['value'] 		= isset( $this->_content[ 'facets' ][ $f ] ) ? $this->_content[ 'facets' ][ $f ] : '';
			$tmp  = '<input '.$this->_renderAttributes($attributes).'/>';
			$tmp = org_glizy_helpers_Html::label( $f, $f,  false, $tmp );

			$output .= org_glizy_helpers_Html::applyItemTemplate( $tmp, false );
		}
		$output .= org_glizy_helpers_Html::hidden( 'facets' , implode( ',', $this->facets ) );


		$ajaxUrl .= 'ajax.php?pageId='.$this->_application->getPageId().'&ajaxTarget='.$this->getId();
		$output .= <<<EOD
<script type="text/javascript">
jQuery(document).ready(function() {
	var ajaxUrl = "$ajaxUrl";
	var tags = $tags;

    jQuery("input.inputTag").tagInput({
      tags:tags,
      sortBy:"tag",
      //suggestedTags: $tagsSuggest,
      tagSeparator:" ",
      autoFilter:true,
      autoStart:false,
      boldify:true
    })

	jQuery( "#solrAdminForm" ).submit( function(){
		var errors = [];
		if ( jQuery('#row_0').val() == "" ) errors.push( "Campo link della risorsa" );
		if ( jQuery('#row_1').val() == "" ) errors.push( "Riga #1" );

		if ( errors.length )
		{
			Glizy.showWarningMessage( GlizyLocale.REQUIREDFIELDS, errors );
		}
		else
		{
			jQuery.modal('<div></div>', {
				close: false,
				overlayCss:{
					backgroundColor:"#000"
				},
				overlayClose: false
			});

			jQuery.ajax( { url: ajaxUrl,
						type: 'POST',
						data: jQuery(this).serializeArray(),
						dataTypeString: 'json',
						success: function( response, r, a ) {
							jQuery.modal.close();
						}});
		}
		return false;
	});
});
</script>
EOD;

		$this->addOutputCode( $output );
	}

	function process_ajax()
	{
		$info = array();
		$info[ 'fields' ] = explode( ',', __Request::get( 'fields', '' ) );
		$info[ 'row_0' ] = __Request::get( 'row_0', '' );
		$info[ 'row_1' ] = __Request::get( 'row_1', '' );
		$info[ 'row_2' ] = __Request::get( 'row_2', '' );
		$info[ 'row_3' ] = __Request::get( 'row_3', '' );
		$info[ 'row_4' ] = __Request::get( 'row_4', '' );
		$info[ 'facets' ] = array();
		$facets = explode( ',', __Request::get( 'facets', '' ) );
		foreach( $facets as $f )
		{
			$value = __Request::get( $f );
			if ( $value )
			{
				$info[ 'facets' ][ $f ] = $value;
			}
		}

		org_glizy_Registry::set( it_gruppometa_metacms_modules_solr_Solr::getRegistryPath(), serialize($info) );
		return true;
	}

	private function retrieveStructure()
	{
		$this->facets = array();
		$this->fields = array();

		$url = __Config::get( it_gruppometa_metacms_modules_solr_Solr::CONFIG_URL ).'/admin/luke?numTerms=0';
		$xmlString = file_get_contents( $url );

		$dom = new DomDocument();
		$dom->loadXml( $xmlString );
		$lstNodes = $dom->getElementsByTagName( 'lst' );
		foreach( $lstNodes as $n )
		{
			$name = $n->getAttribute( 'name' );

			if ( preg_match("/^.*(_t|_s)$/i", $name) )
			{
				$this->fields[] = $name;
			}
			else if ( preg_match("/^.*_facet$/i", $name) )
			{
				$this->facets[] = $name;
			}
		}

		sort( $this->fields );
		sort( $this->facets );
	}
}
?>

<?php
class it_gruppometa_metacms_modules_solr_views_components_RecordSetList extends org_glizy_components_Component
{
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
		$this->_content['records'] 	= null;

		$dom = $this->_parent->getDom();

		if ( is_object( $dom ) )
		{
			$this->_content['records'] = array();

			$pref = it_gruppometa_metacms_modules_solr_Solr::getPreferences();

			$availableFields = $pref[ 'fields' ];
			$tokenLineUrl = $this->splitTemplateInParts( $pref[ 'row_0' ] );
			$tokenLine1 = $this->splitTemplateInParts( $pref[ 'row_1' ] );
			$tokenLine2 = $this->splitTemplateInParts( $pref[ 'row_2' ] );
			$tokenLine3 = $this->splitTemplateInParts( $pref[ 'row_3' ] );
			$tokenLine4 = $this->splitTemplateInParts( $pref[ 'row_4' ] );

			$cssClass 			= explode(',', $this->getAttribute('cssClass'));
			$tempCssClass 		= $cssClass;
			$resultNode = $dom->getElementsByTagName( 'result' )->item(0);
			$this->_content['totalRecords'] = intval( $resultNode->getAttribute( 'numFound' ) );
			$docNodes = $resultNode->getElementsByTagName( 'doc' );
			foreach( $docNodes as $doc )
			{
				$fields = array();
				$arrNodes = $doc->getElementsByTagName( 'arr' );
				foreach( $arrNodes as $arr )
				{
					if ( !isset( $fields[ $arr->getAttribute( 'name' ) ] ) ) $fields[ $arr->getAttribute( 'name' ) ] = array();
					$strNodes = $arr->getElementsByTagName( 'str' );
					foreach( $strNodes as $str )
					{
						$fields[ $arr->getAttribute( 'name' ) ][] =	utf8_decode( $str->firstChild->nodeValue );
					}
				}

				$strNodes = $doc->getElementsByTagName( 'str' );
				foreach( $strNodes as $str )
				{
					$fields[ $str->getAttribute( 'name' ) ] = array( utf8_decode( $str->firstChild->nodeValue ));
				}

				if (!count($tempCssClass))
				{
					$tempCssClass = $cssClass;
				}

				$item = array();
				$item[ '__cssClass__' ] = count($tempCssClass) ? array_shift($tempCssClass) : '';
				$item[ 'row_1' ] = $this->processToken( $tokenLine1, $fields, $availableFields );
				$item[ 'row_2' ] = $this->processToken( $tokenLine2, $fields, $availableFields );
				$item[ 'row_3' ] = $this->processToken( $tokenLine3, $fields, $availableFields );
				$item[ 'row_4' ] = $this->processToken( $tokenLine4, $fields, $availableFields );
				$item[ '__url__' ] = $this->processToken( $tokenLineUrl, $fields, $availableFields, true );
				if ( empty( $item[ 'row_1' ]  ) ) $item[ 'row_1' ]  = $item[ '__url__' ];
				$item[ 'score' ] = number_format( $doc->getElementsByTagName( 'float' )->item(0)->nodeValue, 2 );
				$this->_content['records'][] = $item;
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


	private function processToken( $token, $item, $availableFields, $isLink = false )
	{
		$output = '';
		$charsToTrim = '';
		$skipNext = false;

		foreach( $token as $v )
		{
			if ( strlen( $v ) > 1)
			{
				if ( in_array( $v, $availableFields ) )
				{
					if ( isset( $item[ $v ] ) )
					{
						if ( !$isLink )
						{
							$itemValue = glz_encodeOutput( html_entity_decode( strip_tags( implode( ' ', $item[ $v ] ) ) ) );
							$output .= trim( $itemValue );
						}
						else
						{
							$linkValues = $item[ $v ];
							foreach( $linkValues as $link )
							{
								if ( strpos( $link, 'http://' ) !== false )
								{
									if ( strpos( $link, '; URL=' ) )
									{
										list( $a, $link ) = explode( '; URL=', $link );
									}
									$output .= trim( $link );
									break;
								}
							}
						}
						$skipNext = false;
					}
					else
					{
						$skipNext = true;
					}
				}
				else
				{
					$output .= $v;
					$skipNext = false;
				}
			}
			else
			{
				$charsToTrim .= $v;
				if ( !$skipNext )
				{
					$output .= $v;
				}
			}
		}

		$output = rtrim( $output, $charsToTrim );
		return $output;
	}



	private function splitTemplateInParts( $template )
	{
		preg_match_all( '/(\w*)(\W?)/ui', $template, $match );
		$result = array();
		if ( count( $match ) )
		{
			for( $i = 0; $i < count( $match[ 0 ] ); $i++ )
			{
				if ( !empty( $match[ 1 ][ $i ] ) ) $result[] = $match[ 1 ][ $i ];
				if ( !empty( $match[ 2 ][ $i ] ) ) $result[] = $match[ 2 ][ $i ];
			}
		}
		return $result;
	}

}

if (!class_exists('it_gruppometa_metacms_modules_solr_views_components_RecordSetList_render'))
{
	class it_gruppometa_metacms_modules_solr_views_components_RecordSetList_render extends org_glizy_components_render_Render
	{
		function getDefaultSkin()
		{
			$skin = <<<EOD
<div class="solr solrResult searchResults" tal:condition="php: !is_null(Component['records'])">
	<span tal:omit-tag="" tal:condition="php: count(Component['records'])">
		<p class="solrTotal">Documenti trovati: <span tal:content="Component/totalRecords" /></p>
		<div tal:repeat="item Component/records" tal:attributes="class item/__cssClass__">
				<h4 tal:content="structure item/row_1"></h4>
				<p tal:condition="item/row_2" tal:content="structure item/row_2"></p>
				<p tal:condition="item/row_3" tal:content="structure item/row_3"></p>
				<p tal:condition="item/row_4" tal:content="structure item/row_4"></p>
				<p class="solrInfo">
					<a class="show" tal:attributes="href item/__url__;" title="vedi" rel="external">Vedi</a>
					<span class="score">Rilevanza: <span tal:omit-tag="" tal:content="item/score" /></span>
				</p>
		</div>
	</span>
	<span tal:omit-tag="" tal:condition="php: !count(Component['records'])">
		<p tal:content="php:__T('MW_NO_RECORD_FOUND')"></p>
	</span>
</div>

EOD;
			return $skin;
		}
	}
}
?>
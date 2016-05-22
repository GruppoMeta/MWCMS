<?php
class museoweb_modules_pico_thesaurus_Parser
{
	var $mapIt;
	var $mapEn;
	var $plainMap;
	var $fileName;
	var $cacheObj;
	var $liPos = 0;

	function createCacheObj()
	{
		$this->fileName = org_glizy_Paths::getRealPath('CACHE_CODE').'/thesaurus.xml';
		$options = array(
			'cacheDir' => org_glizy_Paths::get('CACHE_CODE'),
			'lifeTime' => -1,
			'readControlType' => '',
			'fileExtension' => '.php'
		);

		$this->cacheObj = org_glizy_ObjectFactory::createObject('org.glizy.cache.CacheFile', $options);
	}

	function parse()
	{
		$this->createCacheObj();
		$source = realpath( dirname( __FILE__ ) .'/thesaurus.skos.xml' );
		if ( !file_exists( $this->fileName ) )
		{
			copy( $source, $this->fileName );
		}

		$cacheFileName = $this->cacheObj->verify( $this->fileName, $this->fileName );
		if ($cacheFileName===false )
		{
			// compila
			$this->map = array();
			$this->plainMap = array();

			$xml = new DOMDocument( $this->fileName );
			$xml->load( $this->fileName, LIBXML_NOERROR );
			$rootNode = $xml->documentElement;
			$this->compileNodes( $rootNode );
			$mainDescription = $rootNode->getElementsByTagName( 'Description' )->item( 0 );
			$this->compileList( $this->plainMap[ $mainDescription->getAttribute( 'rdf:about' ) ], 0, true );

			$info = array( 	'mapIt' => $this->mapIt,
							'mapEn' => $this->mapEn,
							'plainMap' => $this->plainMap );

			$this->cacheObj->save( serialize( $info ), NULL, $this->fileName );
		}
	}

	function read()
	{
		// $this->createCacheObj();
		$this->parse();
		$cacheFileName = $this->cacheObj->verify( $this->fileName, $this->fileName );
		$file = file_get_contents( $cacheFileName );
		return unserialize( $file );
	}

	function compileList( $node, $level, $start = false )
	{
		$this->liPos++;
		if ( $start )
		{
			$this->mapIt .= '<ul id="thesaurus">';
			$this->mapEn .= '<ul>';
		}

		if ( $level <= 1 )
		{
			$this->mapIt .= '<li id="thesaurus'.$this->liPos.'"><span>'.utf8_decode( $node[ 'label' ][ 'it' ] ).'</span>';
			$this->mapEn .= '<li  id="thesaurus'.$this->liPos.'"><span>'.utf8_decode( $node[ 'label' ][ 'en' ] ).'</span>';
		}
		else
		{
			$this->mapIt .= '<li id="thesaurus'.$this->liPos.'"><a href="'.$node[ 'link' ].'">'.utf8_decode( $node[ 'label' ][ 'it' ] ).'</a>';
			$this->mapEn .= '<li id="thesaurus'.$this->liPos.'"><a href="'.$node[ 'link' ].'">'.utf8_decode( $node[ 'label' ][ 'en' ] ).'</a>';
		}

		if ( count( $node[ 'child' ] ) )
		{
			$this->mapIt .= '<ul>';
			$this->mapEn .= '<ul>';
			for ($i=0; $i<count( $node[ 'child' ] ); $i++)
			{
				$this->compileList( $this->plainMap[ $node[ 'child' ][ $i ] ], $level+1 );
			}

			$this->mapIt .= '</ul>';
			$this->mapEn .= '</ul>';
		}
		$this->mapIt .= '</li>';
		$this->mapEn .= '</li>';

		if ( $start )
		{
			$this->mapIt .= '</ul>';
			$this->mapEn .= '</ul>';
		}
	}



	function compileNodes( $node )
	{
		foreach( $node->childNodes as $n )
		{
			if ( $n->nodeName == 'rdf:Description' )
			{
				$label = array( 'it' => 'Thesaurus', 'en' => 'Thesaurus' );
				$narrower = array();

				foreach( $n->childNodes as $nn )
				{
					switch ( $nn->nodeName )
					{
						case 'skos:prefLabel':
							$label[ $nn->getAttribute( 'xml:lang' ) ] = $nn->nodeValue;
							break;

						case 'skos:narrower':
						case 'skos:hasTopConcept':
							$narrower[] = $nn->getAttribute( 'rdf:resource' );
							break;
					}
				}
				$this->plainMap[ $n->getAttribute( 'rdf:about' ) ] = array( 'link' => $n->getAttribute( 'rdf:about' ), 'label' => $label, 'child' => $narrower );
			}
		}
	}

}
?>
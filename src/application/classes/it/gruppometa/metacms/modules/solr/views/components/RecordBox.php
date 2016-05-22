<?php
class it_gruppometa_metacms_modules_solr_views_components_RecordBox extends org_glizy_components_Component
{
	/**
	 * Init
	 *
	 * @return	void
	 * @access	public
	 */
	function init()
	{
		$this->defineAttribute('title', 			false,	'',		COMPONENT_TYPE_STRING);
		$this->defineAttribute('cssClass', 			false,	'even,odd',		COMPONENT_TYPE_STRING);
		$this->defineAttribute('query', 			false,	'',		COMPONENT_TYPE_STRING);
		$this->defineAttribute('fields', 			false,	'',		COMPONENT_TYPE_STRING);
		$this->defineAttribute('sort', 				false,	'score desc',		COMPONENT_TYPE_STRING);
		$this->defineAttribute('numRecord', 		false,	3,		COMPONENT_TYPE_INTEGER);
		parent::init();
	}

	function process()
	{
		$this->_content = array(
									'title' => $this->getAttribute('title'),
									'records' => array(),
									'total' => 0,
								);

		$language = $this->_application->getLanguage();
		$rows = $this->getAttribute('numRecord');
		$sort = urlencode($this->getAttribute('sort'));
		$query = urlencode($this->getAttribute('query'));
		$fields = urlencode($this->getAttribute('fields'));
        $url = __Config::get( it_gruppometa_metacms_modules_solr_Solr::CONFIG_URL );
        $url .= 'select?wt=json&version=2.2&start=0&rows='.$rows.'&indent=on&q='.$query.'+lang_s:'.$language.'&sort='.$sort;
        $url .= '&fl='.$fields;

        $jsonContent = @json_decode(file_get_contents( $url ));
        if ($jsonContent) {
	        $fields = explode(',', $this->getAttribute('fields'));
	        foreach($jsonContent->response->docs as $doc) {
	        	$item = new StdClass;
	        	foreach ($fields as $f) {
	        		$item->$f = is_array($doc->$f) ? implode(' ', $doc->$f) : $doc->$f;
	        	}
	        	$this->_content['records'][] = $item;
	        }
	        $this->_content['total'] = count($this->_content['records']);
        }
	}
}
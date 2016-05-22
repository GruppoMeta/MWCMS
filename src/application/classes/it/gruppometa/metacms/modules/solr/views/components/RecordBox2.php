<?php
class it_gruppometa_metacms_modules_solr_views_components_RecordBox2 extends org_glizy_components_Component
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

		parent::init();

		$profile = museoweb_modules_solr_Module::getSolrProfile();
		$dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
        $dcFields = $dcProxy->getFields();
        $fields = array();
        foreach ($profile as $k=>$v) {
        	if ($profile->{$k}->solr) {
        		$suffix = $dcFields[$k]['solr'];
                $fields[] = $suffix ? $k.'_'.$suffix : $k;
        	}
        }
        $fields[] = 'title';
        $fields[] = 'description_t';
        $fields[] = 'url_s';
        $fields[] = 'module_facet';
        $fields[] = 'score';

        $this->setAttribute('fields', implode($fields, ','));
	}

	function process()
	{
		$this->_content = array(
            'title' => $this->getAttribute('title'),
			'records' => array(),
			'total' => 0,
		);

        $jsonContent = $this->_parent->getResult();

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
<?php
class museoweb_views_components_PageWithIndex extends org_glizy_components_Repeater
{

	/**
	 * Return the component information
	 *
	 * @return	array	component informaton.
	 * @access	public
	 * @static
	 */
	function getInfo()
	{
		$info 					= parent::info();
		$info['name']			= 'Page With Index';
		$info['class'] 			= 'org.minervaeurope.museoweb.PageWithIndex';
		$info['package'] 		= 'Museo&Web CMS';
		$info['version'] 		= '1.0.0';
		$info['author'] 		= 'Daniele Ugoletti, Gruppo Meta';
		$info['author-email'] 	= 'daniele.ugoletti@gruppometa.it';
		$info['url'] 			= 'http://www.minervaeurope.org';
		return $info;
	}

	function process()
	{
		parent::process();

		// add the virtual menu in the navigation bar
		$contentArray = $this->newDataFormat ? $this->_content : org_glizy_helpers_Convert::formEditObjectToStdObject($this->_content);
		$currentMenu = &$this->_application->getCurrentMenu();
		$siteMap  = &$this->_application->getSiteMap();
		
		for($i=0; $i<$this->numRecords; $i++)
		{
			$menu = org_glizy_application_SiteMap::getEmptyMenu();
			$menu['title'] 		= $contentArray[$i]->title;
			if ( empty( $menu['title'] ) ) continue;
			$menu['id']			= 9000+$i;
			$menu['pageType']	= $currentMenu->pageType;
			$menu['printPdf']	= $currentMenu->printPdf;
			$menu['hasComment']	= $currentMenu->hasComment;
			$menu['url'] 		= org_glizy_helpers_Link::addParams(array('pag' => $i));
			$siteMap->addChildMenu($currentMenu, $menu);
		}

		// load only the selected page
		$currPage = intval(org_glizy_Request::get('pag', 0));
		$this->contentCount = $currPage;

		if ( $this->numRecords > 0 ) {
			$this->_application->setPageId(9000+$currPage);
			$evt = array('type' => GLZ_EVT_SITEMAP_UPDATE );
			$this->dispatchEvent($evt);
		}

		org_glizy_components_Component::process();
	}
}

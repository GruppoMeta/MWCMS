<?php

class museoweb_search_Module extends org_glizy_plugins_PluginClient
{
    protected $tableName;
    protected $title;
    protected $description;
    protected $pageType;

    function run(&$parent, $params)
    {
        $application = &org_glizy_ObjectValues::get('org.glizy', 'application');
        $siteMap = &$application->getSiteMap();
        $menu = $siteMap->getMenuByPageType($this->pageType);
        if ($menu && $menu->isVisible) {
            $it = org_glizy_objectFactory::createModelIterator('museoweb.search.models.Content');
            $it->load('searchModule', array(':type' => $this->tableName, ':words' => $params['search'], ':language' => $params['languageId']));

            foreach ($it as $ar) {
                $result = $parent->getResultStructure();
    			$result['title'] = $ar->{$this->title};
                $result['description'] = $ar->{$this->description};
                $result['__weight__'] = $ar->score;
                $result['__url__'] 	= __Link::makeLink($this->routeUrl, array('title' => $ar->{$this->title}, 'document_id' => $ar->document_id, $this->title => $ar->{$this->title} ));

    			$parent->addResult($result);
            }
        }
	}
}
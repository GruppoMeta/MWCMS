<?php

class museoweb_search_Content extends org_glizy_plugins_PluginClient
{
    function run(&$parent, $params)
    {
        $application = &org_glizy_ObjectValues::get('org.glizy', 'application');
        $speakingUrlManager = $application->retrieveProxy('org.glizycms.speakingUrl.Manager');

        $it = org_glizy_objectFactory::createModelIterator('museoweb.search.models.Content');
        $it->load('searchPage', array(':words' => $params['search'], ':language' => $params['languageId']));

        foreach ($it as $ar) {
            $result = $parent->getResultStructure();
			$result['title'] = $ar->title;
            $result['description'] = $ar->description != 'descrizione' ? $ar->description : '';
            $result['__weight__'] = $ar->score;
            $result['__url__'] 	= __Link::makeSimpleLink($ar->title, $speakingUrlManager->makeUrl('internal:'.$ar->pageId));
			$parent->addResult($result);
        }
	}
}
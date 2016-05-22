<?php
class museoweb_views_components_DublinCore extends org_glizy_components_Component
{
	function render_html()
	{
		$currentMenu = $this->_application->getCurrentmenu();

		$this->_application->getLanguage();
		$dc = <<<EOD
<meta http-equiv="content-language" content="{$this->_application->getLanguage()}" />
<meta name="Generator" content="Museo &amp; Web CMS - Copyright (C) 2005, 2014 Ministero per i beni e le attivit&agrave; culturali" />
<meta name="keywords" content="{$currentMenu->keywords}" />
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<meta name="DC.Title" content="{$currentMenu->title}" />
<meta name="DC.Creator" content="{$currentMenu->creator}" />
<meta name="DC.Subject" content="{$currentMenu->subject}" />
<meta name="DC.Description" content="{$currentMenu->description}" />
<meta name="DC.Publisher" content="{$currentMenu->publisher}" />
<meta name="DC.Contributor" content="{$currentMenu->contributor}" />
<meta name="DC.Date" content="(SCHEME=ISO8601) {$currentMenu->modificationDate}" />
<meta name="DC.Type" content="{$currentMenu->type}" />
<meta name="DC.Format" content="(SCHEME=IMT) text/html" />
<meta name="DC.Identifier" content="{$currentMenu->identifier}" />
<meta name="DC.Source" content="{$currentMenu->source}" />
<meta name="DC.Language" content="(SCHEME=ISO639-1) {$this->_application->getLanguage()}" />
<meta name="DC.Relation" content="{$currentMenu->relation}" />
<meta name="DC.Coverage" content="{$currentMenu->coverage}" />
<meta name="DC.Rights" content="" />
EOD;
		$this->addOutputCode($dc);
	}
}

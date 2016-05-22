<?php
/* SVN FILE: $Id$ */

/**
 * @copyright Copyright(c) 2005-2009 Ministero per i beni e le attività culturali. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * Museo & Web CMS is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 * @author		Daniele Ugoletti <daniele.ugoletti@gruppometa.it>, Gruppo Meta <http://www.gruppometa.it>
 */


$queryStr = $_SERVER["QUERY_STRING"];

require_once("core/core.inc.php");
require_once("application/libs/feedcreator/feedcreator.class.php");
$application = &org_glizy_ObjectFactory::createObject('org.glizycms.core.application.Application', 'application');
$application->runSoft();
$siteProp = $application->getSiteProperty();

$rss = new UniversalFeedCreator();
$rss->title = $siteProp['title'];
$rss->description = $siteProp['title'];
$rss->cssStyleSheet = '';

$defaultUrl = GLZ_HOST.'/';
$rss->link = $defaultUrl;
$rss->syndicationURL = $defaultUrl.'feed.php';

$iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.news.models.Model', 'newsHome', array( 'limit' => array(0,20)));
foreach($iterator as $ar) {
	$item = new FeedItem();
	$item->title = $ar->newsdetail_title;
	$item->link = org_glizy_helpers_Link::makeuRL('museoweb_News', array('document_id' => $ar->document_id, 'newsdetail_title' => $ar->newsdetail_title));
	$item->description = $ar->newsdetail_body;

	//optional
	$item->descriptionTruncSize = 500;
	$item->descriptionHtmlSyndicated = true;

	$item->date = formatFeedDate( $ar->document_creationDate );
	$item->source = $defaultUrl;
	$item->author = '';

	$rss->addItem($item);
}

$iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.events.models.Model', 'all', array( 'limit' => array(0,20)));
foreach($iterator as $ar) {
	$item = new FeedItem();
	$item->title = $ar->eventdetail_title;
	$item->link = org_glizy_helpers_Link::makeuRL('events', array('document_id' => $ar->document_id, 'eventdetail_title' => $ar->eventdetail_title));
	$item->description = $ar->eventdetail_description;

	//optional
	$item->descriptionTruncSize = 500;
	$item->descriptionHtmlSyndicated = true;

	$item->date = formatFeedDate( $ar->document_creationDate );
	$item->source = $defaultUrl;
	$item->author = '';

	$rss->addItem($item);
}



// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
// MBOX, OPML, ATOM, ATOM0.3, HTML, JS
if (isset($_GET['type']) && $_GET['type']=='rss2') echo $rss->saveFeed("RSS2.0", "cache/feed.xml");
else if (isset($_GET['type']) && $_GET['type']=='atom030')echo $rss->saveFeed("ATOM0.3", "cache/feed.xml");
else echo $rss->saveFeed("RSS1.0", "cache/feed.xml");

function formatFeedDate( $date )
{
	if ( empty( $date ) ) return "";
	$dateFormat = __T( 'GLZ_DATETIME_TOTIME_REGEXP' );
	$t = strtotime( preg_replace( $dateFormat[0], $dateFormat[1], $date ) );
	return date("r", $t);
}

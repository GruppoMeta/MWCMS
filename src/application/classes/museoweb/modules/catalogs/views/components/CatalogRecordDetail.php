<?php
/* SVN FILE: $Id: SiteSelect.php 246 2009-12-11 23:50:39Z ugoletti $ */

/**
 * @copyright Copyright(c) 2005-2009 Ministero per i beni e le attivit� culturali. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * Museo & Web CMS is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 * @author		Daniele Ugoletti <daniele.ugoletti@gruppometa.it>, Gruppo Meta <http://www.gruppometa.it>
 * @package		Museo&Web CMS
 * @category	Component
 */

glz_import('org.glizy.components.RecordDetail');

class museoweb_modules_catalogs_views_components_CatalogRecordDetail extends org_glizy_components_RecordDetail
{
	function getContent()
	{
		$result = parent::getContent();
	    /*
		// crea il link al sito
		if ($result['catalogdetail_FK_touristsite_id'] > 0)
		{
			$rsTouristSite = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristSite');
			$res = $rsTouristSite->find(array('touristsite_id' => $result['catalogdetail_FK_touristsite_id']));
			if ($res)
			{
				if ( $result['catalog_type'] == 'CATALOG' )
				{

					$touristRoute = explode(',', $rsTouristSite->touristsitedetail_FK_touristroute);
					$result['catalogdetail_FK_touristsite_id'] = '&nbsp;-&nbsp;'.org_glizy_helpers_Link::makeLink('touristroutes', array(MW_TouristRoute => $touristRoute[0]!='' ? $touristRoute[0] : '00', MW_TouristSite => $result['catalogdetail_FK_touristsite_id'], 'label' => org_glizy_locale_Locale::get('MW_CATALOG_VIEWSITE')));
				}
				else
				{
					$result['catalogdetail_FK_touristsite_id'] = org_glizy_helpers_Link::makeLink('touristsites', array( 'touristsite_id' => $rsTouristSite->touristsite_id, 'touristsitedetail_name' => $rsTouristSite->touristsitedetail_name, 'label' => $rsTouristSite->touristsitedetail_name ) );
				}
			}
			else
			{
				$result['catalogdetail_FK_touristsite_id'] = '';
			}
		}
		else
		{
			$result['catalogdetail_FK_touristsite_id'] = '';
		}

		// cerca i link agli itinerari collegati
		$result['routes'] = array();
		$ar = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristRoute2catalog');
		$it = &$ar->loadQuery(	'all', array(
								'filters' => array('touristroute2catalog_FK_catalog_id' => $result['catalog_id'])
							));
		$linkedId = array();
		while($it->hasMore())
		{
			$arC = &$it->current();
			$it->next();
			$linkedId[] = $arC->touristroute2catalog_FK_touristsite_id;
		}
		if (count($linkedId))
		{
			$ar = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristRoute');
			$iterator = &$ar->loadQuery(	'all', array(
											'filters' => array('touristroute_id' => array('IN ('.implode($linkedId, ',').')'))
										));
			$cssClass = array('even', 'odd');
			while ($iterator->hasMore())
			{
				$arC = &$iterator->current();
				$tmp  = $arC->getValuesAsArray();
				if (!count($tempCssClass)) $tempCssClass = $cssClass;
				if (count($tempCssClass)) $tmp['__cssClass__'] = array_shift($tempCssClass);
				$tmp['__url__'] = org_glizy_helpers_Link::makeURL('touristroutesSearch', array('touristroute_id' => $arC->touristroute_id));

				// immagine
				$img = org_glizy_ObjectFactory::createComponent('org.glizy.components.Image', $this->_application, $this, '', 'tmp', 'tmp');
				$img->init();
				$img->attachMedia($arC->touristroutedetail_map);
				$img->setAttribute( 'width', __Config::get( 'IMG_LIST_WIDTH' ) );
				$img->setAttribute( 'height', __Config::get( 'IMG_LIST_HEIGHT' ) );
				$tmp['touristroutedetail_map'] = $img->getContent('glz:RecordSetList');
				$result['routes'][] = $tmp;
				$iterator->next();
			}
		}

		// cerca i link alle tappe collegate
		$result['sites'] = array();
		$ar = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristSite2catalog');
		$it = &$ar->loadQuery(	'all', array(
								'filters' => array('touristsite2catalog_FK_catalog_id' => $result['catalog_id'])
							));
		$linkedId = array();
		while($it->hasMore())
		{
			$arC = &$it->current();
			$it->next();
			$linkedId[] = $arC->touristsite2catalog_FK_touristsite_id;
		}
		if (count($linkedId))
		{
			$ar = &org_glizy_ObjectFactory::createModel('org.minervaeurope.museoweb.models.TouristSite');
			$iterator = &$ar->loadQuery(	'all', array(
											'filters' => array('touristsite_id' => array('IN ('.implode($linkedId, ',').')'))
										));
			$cssClass = array('even', 'odd');
			while ($iterator->hasMore())
			{
				$arC = &$iterator->current();
				$tmp  = glz_encodeOutput($arC->getValuesAsArray());
				if (!count($tempCssClass)) $tempCssClass = $cssClass;
				if (count($tempCssClass)) $tmp['__cssClass__'] = array_shift($tempCssClass);
				$tmp['__url__'] = org_glizy_helpers_Link::makeURL('touristsites', array('touristsite_id' => $arC->touristsite_id, 'touristsitedetail_name' => $arC->touristsitedetail_name));

				// immagine
				$img = org_glizy_ObjectFactory::createComponent('org.glizy.components.Image', $this->_application, $this, '', 'tmp', 'tmp');
				$img->init();
				$img->setAttribute( 'width', __Config::get( 'IMG_LIST_WIDTH' ) );
				$img->setAttribute( 'height', __Config::get( 'IMG_LIST_HEIGHT' ) );
				$img->attachMedia($arC->touristsitedetail_image1);
				$tmp['touristsitedetail_image1'] = $img->getContent('glz:RecordSetList');

				$result['sites'][] = $tmp;
				$iterator->next();
			}
		}
        */

        // if ($result->catalogdetail_urlInternal)  {
        //     $result->catalogdetail_urlInternal = __Link::makeUrl('link', array('pageId' => $result->catalogdetail_urlInternal));
        // }

		return $result;
	}
}
?>
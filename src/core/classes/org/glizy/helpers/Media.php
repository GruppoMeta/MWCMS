<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 *
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */

class org_glizy_helpers_Media extends GlizyObject
{
	function getImageById($id, $direct=false, $cssClass='', $style='', $onclick='', $title='')
	{
		$media = &org_glizy_media_MediaManager::getMediaById($id);
		if (is_null($media)) return '';
		$attributes = array();
		$attributes['alt'] = $media->title;
		$attributes['title'] = $title ? :$media->title;
		$attributes['class'] = $cssClass;
		$attributes['style'] = $style;
		$attributes['onclick'] = $onclick;
		$attributes['src'] = $direct ? $media->getFileName() : 'getImage.php?id='.$id;
		return org_glizy_helpers_Html::renderTag('img', $attributes);
	}


	function getResizedImageById($id, $direct=false, $width, $height, $crop=false, $cssClass='', $style='', $onclick='')
	{
		$media = &org_glizy_media_MediaManager::getMediaById($id);
		if (is_null($media)) return '';
		if ($direct)
		{
			$thumb = $media->getThumbnail($width, $height, $crop);
		}
		$attributes = array();
		$attributes['alt'] = $media->title;
		$attributes['title'] = $media->title;
		$attributes['class'] = $cssClass;
		$attributes['style'] = $style;
		$attributes['onclick'] = $onclick;
		$attributes['src'] = $direct ? $thumb['fileName'] : 'getImage.php?id='.$id.'&w='.$width.'&h='.$height.'&c='.$crop;
		return org_glizy_helpers_Html::renderTag('img', $attributes);
	}

	function getImageUrlById($id, $width, $height, $crop=false, $cropOffset=1, $forceSize=false, $useThumbnail=false )
	{
		return 'getImage.php?id='.$id.'&w='.$width.'&h='.$height.'&c='.($crop ? '1' : '0').'&co='.$cropOffset.'&f='.($forceSize ? '1' : '0').'&t='.($useThumbnail ? '1' : '0').'&.jpg';
	}

	function getResizedImageUrlById($id, $direct=false, $width, $height, $crop=false, $cropOffset=1, $forceSize=false )
	{
		if ($direct)
		{
			$media = &org_glizy_media_MediaManager::getMediaById($id);
			if (is_null($media)) return '';
			$thumb = $media->getThumbnail($width, $height, $crop, $cropOffset, $forceSize );
			return $thumb['fileName'];
		}
		return org_glizy_helpers_Media::getImageUrlById( $id, $width, $height, $crop, $cropOffset, $forceSize );
	}

	function getUrlById($id, $direct=false)
	{
		if ($direct)
		{
		$media = &org_glizy_media_MediaManager::getMediaById($id);
		if (is_null($media)) return '';
			return $media->getFileName();
		}
		else return 'getImage.php?id='.$id;
	}

	function getFileUrlById($id, $direct=false)
	{
		if ($direct)
		{
		$media = &org_glizy_media_MediaManager::getMediaById($id);
		if (is_null($media)) return '';
			return $media->getFileName(false);
		}
		else return 'getFile.php?id='.$id;
	}

	/* deprecated */
	function getThumbnailById($id, $width, $height, $crop=false, $class='', $onclick='')
	{
		return org_glizy_helpers_Media::getResizedImageById($id, false, $width, $height, $crop, $class, '', '');
	}
}

class __Media extends org_glizy_helpers_Media
{
}
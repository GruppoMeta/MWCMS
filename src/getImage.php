<?php
if (!defined('GLZ_LOADED'))
{
	require_once('core/core.inc.php');
	$application = org_glizy_ObjectFactory::createObject('org.glizycms.core.application.Application', 'application');
	org_glizy_Paths::addClassSearchPath('admin/application/classes/');

	if (file_exists(org_glizy_Paths::get('APPLICATION_STARTUP')))
	{
		// if the startup folder is defined all files are included
		glz_require_once_dir(org_glizy_Paths::get('APPLICATION_STARTUP'));
	}
}


$id 	= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : NULL;
$w 		= isset($_REQUEST['w']) ? $_REQUEST['w'] : NULL;
$h 		= isset($_REQUEST['h']) ? $_REQUEST['h'] : NULL;
$force 	= isset($_REQUEST['f']) ? $_REQUEST['f']=='true' || $_REQUEST['f']=='1': false;
$crop 	= isset($_REQUEST['c']) ? $_REQUEST['c']=='true' || $_REQUEST['c']=='1' : false;
$useThumbnail 	= isset($_REQUEST['t']) ? $_REQUEST['t']=='true' || $_REQUEST['t']=='1' : false;
$cropOffset 	= isset($_REQUEST['co']) ? $_REQUEST['co'] : 0;

if (is_null($id)) exit;

glz_import('org.glizy.media.MediaManager');
$media = org_glizy_media_MediaManager::getMediaById($id);

if (!$media) {
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found ".$media->originalFileName."</h1>";
    exit();
}

if ( $useThumbnail && $media->ar->media_thumbFileName) {
	$media->ar->media_fileName = $media->ar->media_thumbFileName;
	$media->ar->media_type = 'IMAGE';
	$media = org_glizy_media_MediaManager::getMediaByRecord( $media->ar );
}

if ($media->type!='IMAGE') {
    $iconFile =  $media->getIconFileName();
    header( 'location: '.$iconFile );
}

$originalSize = $media->getOriginalSizes();

// if(!$w || !$h) {
// 	$w = $originalSize['width'];
// 	$h = $originalSize['height'];
// }

// if(!$media->allowDownload) {
// 	$maxWidth = __Config::get('IMG_DOWNLOAD_WIDTH');
//     $maxHeight = __Config::get('IMG_DOWNLOAD_HEIGHT');
//     $w = $w ? min($maxWidth, $w) : $maxWidth;
//     $h = $h ? min($maxHeight, $h) : $maxHeight;
// }

if ($w && $h) {
	//resize the image
	$mediaInfo = $media->getResizeImage($w, $h, $crop, $cropOffset, $force);
} else if($media->watermark){
	$mediaInfo = $media->getResizeImage($originalSize['width'], $originalSize['height']);
} else {
	$mediaInfo = $media->getImageInfo();
}

$fileSize = filesize( $mediaInfo['fileName'] );
$gmdate_mod = gmdate("D, d M Y H:i:s", filemtime( $mediaInfo['fileName'] ) );
if(! strstr($gmdate_mod, "GMT"))
{
	$gmdate_mod .= " GMT";
}
$etag = md5($mediaInfo['fileName'].'/'.$media->ar->media_watermark.'/'.$gmdate_mod);
$expires = 60 * 60 * 24 * 3;
$exp_gmt = gmdate("D, d M Y H:i:s", time() + $expires) . " GMT";
// check304($etag, '');

// send headers then display image
$mimeType = !is_string($mediaInfo['imageType']) ? image_type_to_mime_type($mediaInfo['imageType']) : $mediaInfo['imageType'];
header("Content-Type: ".$mimeType);
header("Accept-Ranges: bytes");
header("Last-Modified: " . $gmdate_mod);
header("Content-Length: " . $fileSize);
header("ETag: " . $etag);
header("Cache-Control: max-age=".$expires.", must-revalidate");
header("Expires: " . $exp_gmt);
@readfile($mediaInfo['fileName']);
exit;

function check304($etag, $gmdate_mod) {
    $if_modified_since = preg_replace("/;.*$/", "", @$_SERVER["HTTP_IF_MODIFIED_SINCE"]);
    if ($if_modified_since == $gmdate_mod || trim(@$_SERVER['HTTP_IF_NONE_MATCH'])==$etag) {
        header('HTTP/1.1 304 Not Modified');
        exit;
    }
}

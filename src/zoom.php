<?php
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : NULL;
$w = isset($_REQUEST['w']) ? intval($_REQUEST['w']) : 0;
if (is_null($id)) exit;
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

$zoomFile = __Paths::get('CACHE').'/zoom_'.$id.'_'.$w.'.xml';
if ( !file_exists( $zoomFile ) )
{
    glz_import('org.glizy.media.MediaManager');
    set_time_limit(0);
    $media = org_glizycms_mediaArchive_MediaManager::getMediaById($id);
	$loader = new DeepzoomLoader();
	if (__Config::get('glizy.media.imageMagick')==true) {
		$adapter = new Deepzoom\ImageAdapter\ImagickWatermark($media->watermark);
	} else {
		$adapter = new Deepzoom\ImageAdapter\GdThumbWatermark($media->watermark);
	}
	$file = new Deepzoom\StreamWrapper\File;
	$descriptor = new Deepzoom\Descriptor($file);
	$converter = new Deepzoom\ImageCreator($file, $descriptor, $adapter);
	$converter->create( realpath( $media->getFileName() ), $zoomFile );
}
echo json_encode( true );


class DeepzoomLoader
{
    public function __construct()
    {
       spl_autoload_register(array($this, 'loadClass'));
       set_include_path(realpath('application/libs/openzoom/Oz/vendor/zend/lib').PATH_SEPARATOR.get_include_path());
    }

    public function loadClass($className)
    {
        if ( strpos($className, '__Config') >0) {
            return true;
        }
        if (strpos($className, 'Deepzoom') === 0) {
            require 'application/libs/openzoom/Oz/'.str_replace('\\','/', $className).'.php';
        } else if (strpos($className, 'Zend_') === 0) {
        	require 'application/libs/openzoom/Oz/vendor/zend/lib/Zend/'.$className.'.php';
        }
    }

}

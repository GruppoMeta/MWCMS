<?php
class museoweb_modules_mag_controllers_ajax_CreateZip extends org_glizy_mvc_core_CommandAjax
{
    function execute()
    {
        if ($this->user->isLogged())
        {
            require_once(org_glizy_Paths::get('APPLICATION').'/libs/dZip.inc.php');
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            $exportFolder = $magProxy->getExportFolder();
            $zipPath = $magProxy->getExportZip();
            @unlink($zipPath);
            if (count(glob($exportFolder.'*')) != 0 ) {
                $zip = new dZip( $zipPath );
                $this->addFolderToZip( $zip, $exportFolder, __Paths::get( 'CACHE' ) );
                $zip->save();
                return true;
            }
        }
    }


    private function addFolderToZip( &$zip, $dir, $baseDir)
    {
        if ($dir_handle = @opendir($dir))
        {
            while ($file_name = readdir($dir_handle))
            {
                if ($file_name!="." &&  $file_name!=".." )
                {
                    if ( !is_dir($dir.$file_name) )
                    {
                        $zipFileName = str_replace( $baseDir, '', $dir.$file_name );
                        $zip->addFile( $dir.$file_name, $zipFileName );
                    }
                    else
                    {
                        $this->addFolderToZip( $zip, $dir.$file_name, $baseDir );
                    }
                }
            }
            closedir($dir_handle);
          return 0;
        }
        else
        {
            return "Could not open directory $dir";
        }
      }
}
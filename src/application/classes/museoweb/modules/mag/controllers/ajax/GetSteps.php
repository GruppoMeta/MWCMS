<?php
class museoweb_modules_mag_controllers_ajax_GetSteps extends org_glizy_mvc_core_CommandAjax
{
    function execute($moduleId, $moduleName, $from, $to, $exportMode)
    {
        if ($this->user->isLogged())
        {
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            $count = $magProxy->getTotalsOfMagToExport($moduleId, $from, $to);

            $start = 1;
            $stop = ceil($count / museoweb_modules_mag_models_proxy_MagProxy::EXPORT_MAG_PER_STEP);
            $steps = array();
            for ($i=$start; $i<=$stop; $i++) {
                $steps[] = array('action' => 'ExportMag', 'params' => array('moduleId' => $moduleId, 'page' => $i));
            }

            if (count($steps)) {
                if ($exportMode=='zip') {
                    $steps[] = array('action' => 'CreateZip',
                                     'params' => array('moduleName' => $moduleName));
                    $steps[] = array('action' => 'end',
                                     'url' => $magProxy->getExportZip());
                } else {
                    $steps[] = array('action' => 'CopyInFolder',
                                     'params' => array('moduleName' => $moduleName ));
                    // todo: localizzare
                    $steps[] = array('action' => 'end',
                                     'message' => 'Esportazione completata');
                }
            }

            // crea la cartella utilizzata per l'esportazione
            $exportFolder = $magProxy->getExportFolder();
            $this->rm($exportFolder.'*');
            @rmdir($exportFolder);
            mkdir($exportFolder);
            return $steps;
        }
    }

    private function rm( $path )
    {
        foreach (glob( $path ) as $filename)
        {
           @unlink($filename);
        }
    }
}
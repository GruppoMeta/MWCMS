<?php
set_time_limit(0);
require_once 'application/libs/PHPExcel/Classes/PHPExcel/IOFactory.php';

class museoweb_massiveImporter_controllers_ModelsExport extends org_glizy_mvc_core_Command
{
    public function execute($moduleId)
    {
        if ($moduleId) {
            $moduleHelper = org_glizy_ObjectFactory::createObject('org.glizycms.helpers.Modules');
            $fields = $moduleHelper->getFields($moduleId, true);
            $header = array();
            foreach ($fields as $k => $c) {
               $header[] = $c->label;
            }

            $excel = new PHPExcel();
            $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $worksheet = $excel->getActiveSheet();
            $worksheet->fromArray($header, NULL, 'A1');

            // redirect output to client browser
            //@ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$moduleId.'.xls"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }
}

<?php
class museoweb_massiveImporter_services_CVSFileService extends museoweb_massiveImporter_services_XLSFileService
{
    public function __construct($options)
    {
        $csv = new PHPExcel_Reader_CSV();
        $csv->setDelimiter($options['delimiter']);
        $csv->setEnclosure($options['enclosure']);
        $excel = $csv->load($options['filePath']);
        $this->worksheet = $excel->getActiveSheet();
    }
}
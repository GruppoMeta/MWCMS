<?php
set_time_limit(0);
ini_set('memory_limit', '512M');
require_once 'application/libs/PHPExcel/Classes/PHPExcel/IOFactory.php';

class museoweb_massiveImporter_services_XLSFileService extends museoweb_massiveImporter_services_AbstractFileService
{
    protected $worksheet;

    public function __construct($options)
    {
        $excel = PHPExcel_IOFactory::load($options['filePath']);
        $this->worksheet = $excel->getActiveSheet();
    }

    public function getHeading()
    {
        $maxCol = $this->worksheet->getHighestDataColumn();
        $data = $this->worksheet->rangeToArray('A1:'.$maxCol.'1');
        return $data[0];
    }

    public function count() {
        return $this->worksheet->getHighestDataRow()-1;
    }

    protected function fetch()
    {
        // in excel le righe iniziano da 1 e si salta anche l'heading
        $i = $this->pos + 2;
        $maxCol = $this->worksheet->getHighestDataColumn();
        $data = $this->worksheet->rangeToArray('A'.$i.':'.$maxCol.$i);

        if (!is_null($data[0][0])) {
            $this->data = new stdClass();
            foreach ($data[0] as $k => $v) {
                $this->data->$k = $v;
            }
        } else {
            $this->data = null;
        }

        $this->pos++;
    }
}
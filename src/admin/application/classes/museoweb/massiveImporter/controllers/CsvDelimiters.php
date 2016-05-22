<?php
class museoweb_massiveImporter_controllers_CsvDelimiters extends org_glizy_mvc_core_Command
{
    public function execute($enclosure, $delimiter)
    {
        if ($enclosure != '' && $delimiter != '') {
            __Session::set('massiveImporter_csv_enclosure', $enclosure);
            __Session::set('massiveImporter_csv_delimiter', $delimiter);
            $this->changeAction('fileValidation');
        } else {
            $c = $this->view->getComponentById('enclosure');
            $c->setAttribute('value', '"');
        }
    }
}
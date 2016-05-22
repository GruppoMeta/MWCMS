<?php
class museoweb_modules_mag_controllers_moduleEdit_ajax_SaveClose extends museoweb_modules_mag_controllers_moduleEdit_ajax_Save
{
    function execute($data)
    {
        $result = parent::execute($data);

        if ($result['errors']) {
            return $result;
        }

        return array('url' => $this->changeAction(''));
    }
}
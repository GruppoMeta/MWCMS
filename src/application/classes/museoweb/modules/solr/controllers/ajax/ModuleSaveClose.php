<?php
class museoweb_modules_solr_controllers_ajax_ModuleSaveClose extends museoweb_modules_solr_controllers_ajax_ModuleSave
{
    function execute($data)
    {
        $result = parent::execute($data);

        $this->directOutput = true;
        return array('url' => $this->changeAction('mapping'));
    }
}
<?php
class museoweb_modules_solr_controllers_ajax_MappingCancel extends org_glizy_mvc_core_CommandAjax
{

    public function execute($data)
    {
        $this->directOutput = true;
        return array('url' => $this->changeAction('mapping'));
    }
}
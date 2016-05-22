<?php
class museoweb_modules_solr_controllers_ajax_SaveAndIndex extends museoweb_modules_solr_controllers_ajax_Save
{
    public function execute($data)
    {
        $this->directOutput = true;
        parent::execute($data);
        return array('callback' => 'mwcms_startAjaxSteps');
    }
}
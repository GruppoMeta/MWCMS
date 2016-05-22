<?php
class museoweb_massiveImporter_controllers_FieldMapping extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $mappingEditor = array(
            'moduleId' => __Session::get('massiveImporter_moduleId'),
            'heading' => __Session::get('massiveImporter_heading'),
            'mapping' => __Session::get('massiveImporter_mapping')
        );

        __Request::set('mappingEditor', $mappingEditor);

        $c = $this->view->getComponentById('mappingDP');
        $c->setAttribute('queryParams', serialize(array('moduleId' => $mappingEditor['moduleId'])));
    }
}
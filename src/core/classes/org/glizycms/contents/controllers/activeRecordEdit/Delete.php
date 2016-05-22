<?php
class org_glizycms_contents_controllers_activeRecordEdit_Delete extends org_glizy_mvc_core_Command
{
    public function execute($id)
    {
// TODO controllo ACL
        if ($id) {
            $c = $this->view->getComponentById('__model');
            $model = $c->getAttribute('value');
            
            $proxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ActiveRecordProxy');
            $proxy->delete($id, $model);
            
            org_glizy_helpers_Navigation::goHere();
        }
    }
}
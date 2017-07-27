<?php
class org_glizycms_contents_controllers_moduleEdit_Delete extends org_glizy_mvc_core_Command
{
    public function execute($id, $model)
    {
        $this->checkPermissionForBackend();
// TODO controllo ACL
        if ($id) {
            $contentproxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ModuleContentProxy');
            $contentproxy->delete($id, $model);
            org_glizy_helpers_Navigation::goHere();
        }
    }
}
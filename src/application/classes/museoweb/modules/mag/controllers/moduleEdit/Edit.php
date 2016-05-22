<?php
class museoweb_modules_mag_controllers_moduleEdit_Edit extends org_glizycms_contents_controllers_moduleEdit_Edit
{

    public function execute($id) {
        if ($id) {
            $c = $this->view->getComponentById('__model');
            $contentproxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ModuleContentProxy');
            $data = $contentproxy->loadContent($id, $c->getAttribute('value'));
            $data['__id'] = $id;
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            if(@$data['mag_lock']) {
                $this->setComponentsAttribute('EditForm', 'readOnly', !$this->user->groupId==1);
            } else {
                if (@$data['ref_id']){
                    list($type, $id, $lang) = explode(':', $data['ref_id']);
                    $data['ref_model_id'] = $type;
                    $data = $magProxy->overrideDataWithOriginalRecordValues($data['ref_id'], $data);
                }
                $magProxy->overrideDataFromNiso($data['img']->importMode, $data['img']);
                $this->setComponentsAttribute('EditForm', 'readOnly', false);
            }
            $this->view->setData($data);
        }
    }
}
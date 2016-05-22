<?php
class museoweb_modules_solr_views_components_ModuleEdit extends org_glizy_components_Input
{
    function process()
    {
        $actions = array(
                            array('strip html', __T('strip html')),
                            array('split date', __T('split date')),
                            array('split pos. 1', __T('split pos. 1')),
                            array('split pos. 2', __T('split pos. 2')),
                            array('split pos. 3', __T('split pos. 3')),
                            array('image', __T('image')),
                            array('fixed', __T('fixed'))
                        );
        $moduleId = __Request::get('id');
        $module = org_glizy_Modules::getModule($moduleId);
        if (!$module) {
            // todo: mostrare errore perché il modulo non esiste
        }

        $moduleHelper = org_glizy_ObjectFactory::createObject('org.glizycms.helpers.Modules');
        $fields = $moduleHelper->getFields($moduleId);
        $result = array('fields' => array(), 'media' => array());
        foreach($fields as $k=>$v) {
            $result[] = $v;
        }

        $evt = array('type' => GLZ_EVT_PAGETITLE_UPDATE, 'data' => __T('Edit mapping').': '.$module->name);
        $this->dispatchEvent($evt);

        $this->setAttribute('type', 'hidden');
        $this->setAttribute('data', ';type=mwcmsModuleEdit;controllername='.$this->getAttribute('ajaxController'), true);
        $this->setAttribute('data', ';module_id='.$moduleId.';fields='.json_encode($result).';actions='.json_encode($actions), true);
    }

}

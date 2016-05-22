<?php
class museoweb_modules_solr_controllers_ajax_DeleteIndex extends org_glizy_mvc_core_CommandAjax
{

    function execute($model)
    {
        if ($this->user->isLogged())
        {
            $modules = org_glizy_Modules::getModules();
            foreach( $modules as $m ) {
                if ($m->classPath.'.models.Model'==$model) {
                    $evt = array('type' => museoweb_modules_solr_Module::EVT_DELETE_MODEL.'@'.$model, 'data' => $m->id);
                    $this->dispatchEvent($evt);
                    break;
                }
            }
        }

        return true;
    }
}

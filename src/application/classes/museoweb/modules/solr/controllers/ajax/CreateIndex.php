<?php
class museoweb_modules_solr_controllers_ajax_CreateIndex extends org_glizy_mvc_core_CommandAjax
{

    function execute($model, $start)
    {
        if ($this->user->isLogged())
        {
            $indexStep = __Config::get('metacms.solr.index.step');
            $it = org_glizy_ObjectFactory::createModelIterator($model);
            $it->limit($start, $indexStep);
            foreach($it as $ar) {
                $evt = array('type' => museoweb_modules_solr_Module::EVT_QUEUE_MODEL.'@'.$model, 'data' => $ar);
                $this->dispatchEvent($evt);
            }
            $evt = array('type' => museoweb_modules_solr_Module::EVT_QUEUE_COMMIT, 'data' => $ar);
            $this->dispatchEvent($evt);
        }

        return true;
    }
}

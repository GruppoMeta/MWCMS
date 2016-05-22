<?php
class museoweb_modules_pico_controllers_ajax_CreateIndex extends org_glizy_mvc_core_CommandAjax
{
    function execute($mapping, $model, $start)
    {
        if ($this->user->isLogged())
        {
            $indexStep = __Config::get('metacms.solr.index.step');
            $it = org_glizy_ObjectFactory::createModelIterator($model);
            $it->limit($start, $indexStep);
            foreach($it as $ar) {
                $evt = array('type' => museoweb_modules_pico_Module::EVT_INDEX_MODEL.'@'.$model, 'data' => $ar );
                $this->dispatchEvent($evt);
            }
        }

        return true;
    }
}

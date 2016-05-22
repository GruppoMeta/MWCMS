<?php
class museoweb_modules_solr_controllers_ajax_GetSteps extends org_glizy_mvc_core_CommandAjax
{
    function execute($from, $to)
    {
        if ($this->user->isLogged())
        {
            $steps = array();
            $indexStep = __Config::get('metacms.solr.index.step');
            $modules = org_glizy_Modules::getModules();
            $moduleEnabled = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').museoweb_modules_solr_Module::REGISTRY_SOLR_MAP_ACTIVE, '')) ?: array();

            // step per cancellare i dati
            foreach( $modules as $m ) {
                $model = $this->getModel($modules, $m->id);
                if (isset($moduleEnabled[$m->id])) {
                     $steps[] = array('action' => 'DeleteIndex', 'params' => array('model' => $model));
                }
            }

            foreach ($moduleEnabled as $k=>$v) {
                if (!$v) continue;
                $model = $this->getModel($modules, $k);
                $it = org_glizy_ObjectFactory::createModelIterator($model);
                $it->exec();
                $count = $it->count();
                if ($count) {
                    $part = ceil($count/$indexStep);
                    for ($i=0; $i<$part;$i++) {
                        $steps[] = array('action' => 'CreateIndex', 'params' => array('model' => $model, 'start' => $i*$indexStep));
                    }
                }
            }

            $steps[] = array('action' => 'IndexLod', 'params' => array());

            $steps[] = array('action' => 'end',
                                     'message' => '{i18n:Indexing finished}');
        }


        return $steps;
    }

    private function getModel(&$modules, $id)
    {
        return $modules[$id]->classPath.'.models.Model';
    }
}
